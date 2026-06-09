<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\CertificateException;

class Signer
{
    public const FILENAME = 'signature';

    private \OpenSSLCertificate $certificate;
    private \OpenSSLAsymmetricKey $privateKey;
    private string $appleWWDRCA;

    /**
     * @throws CertificateException
     */
    public function __construct(?string $certificatePath = null, #[\SensitiveParameter] ?string $password = null)
    {
        if ($certificatePath !== null && $password !== null) {
            $this->setCertificate($certificatePath, $password);
        }

        $this->setAppleWWDRCA(__DIR__ . '/../../certificates/AppleWWDRCAG3.pem');
    }

    /**
     * @throws CertificateException
     */
    public function setCertificate(string $path, #[\SensitiveParameter] string $password): void
    {
        if (!file_exists($path)) {
            throw CertificateException::fileDoesNotExist($path);
        }

        $data = [];
        if (!openssl_pkcs12_read((string) file_get_contents($path), $data, $password)) {
            throw CertificateException::failedToReadPkcs12($path);
        }

        $certificate = openssl_x509_read($data['cert']);
        $privateKey = openssl_pkey_get_private($data['pkey'], $password);

        if ($certificate === false || $privateKey === false) {
            throw CertificateException::failedToReadPkcs12($path);
        }

        $expiry = $this->getCertificateExpiry($certificate);
        if ($expiry !== null && $expiry < time()) {
            throw CertificateException::expired($path, $expiry);
        }

        $this->certificate = $certificate;
        $this->privateKey = $privateKey;
    }

    /**
     * @throws CertificateException
     */
    public function setAppleWWDRCA(string $path): void
    {
        if (!file_exists($path)) {
            throw CertificateException::fileDoesNotExist($path);
        }
        $this->appleWWDRCA = $path;
    }

    public function sign(string $temporaryDirectory): void
    {
        $manifestFile = $temporaryDirectory . ManifestGenerator::FILENAME;

        $openSslArguments = [
            $manifestFile,
            $temporaryDirectory . self::FILENAME,
            $this->certificate,
            $this->privateKey,
            [],
            PKCS7_BINARY | PKCS7_DETACHED
        ];

        if ($this->appleWWDRCA) {
            $openSslArguments[] = $this->appleWWDRCA;
        }

        call_user_func_array('openssl_pkcs7_sign', $openSslArguments);

        $signature = (string) file_get_contents($temporaryDirectory . self::FILENAME);
        $signature = $this->convertPEMtoDER($signature);
        file_put_contents($temporaryDirectory . self::FILENAME, $signature);
    }

    private function getCertificateExpiry(\OpenSSLCertificate $certificate): ?int
    {
        $parsed = openssl_x509_parse($certificate);

        if ($parsed === false) {
            return null;
        }

        return isset($parsed['validTo_time_t']) ? (int) $parsed['validTo_time_t'] : null;
    }

    private function convertPEMtoDER(string $signature): string
    {
        $begin = 'filename="smime.p7s"';
        $end = '------';
        $signature = substr($signature, strpos($signature, $begin) + strlen($begin));

        $signature = substr($signature, 0, (int) strpos($signature, $end));
        $signature = trim($signature);
        $signature = base64_decode($signature);

        return $signature;
    }
}
