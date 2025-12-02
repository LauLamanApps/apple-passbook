<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\CertificateException;

class Signer
{
    public const FILENAME = 'signature';

    /**
     * @var mixed
     * in PHP 7.4 this is a resource, in PHP 8.0 this is a OpenSSLCertificate
     */
    private $certificate;

    /**
     * @var mixed
     * in PHP 7.4 this is a resource, in PHP 8.0 this is a OpenSSLAsymmetricKey
     */
    private $privateKey;
    private string $appleWWDRCA;

    /**
     * @throws CertificateException
     */
    public function __construct(?string $certificatePath = null, ?string $password = null)
    {
        if ($certificatePath !== null && $password !== null) {
            $this->setCertificate($certificatePath, $password);
        }

        $this->setAppleWWDRCA(__DIR__ . '/../../certificates/AppleWWDRCA.pem');
    }

    /**
     * @throws CertificateException
     */
    public function setCertificate(string $path, string $password): void
    {
        if (!file_exists($path)) {
            throw CertificateException::fileDoesNotExist($path);
        }

        $data = [];
        if (!openssl_pkcs12_read((string) file_get_contents($path), $data, $password)) {
            throw CertificateException::failedToReadPkcs12($path);
        }

        $certResource = openssl_x509_read($data['cert']);
        if ($certResource === false) {
            throw new CertificateException(sprintf('Failed to read certificate from "%s".', $path));
        }

        // check expiry
        $expiry = $this->getCertificateExpiryFromResource($certResource);
        if ($expiry !== null && $expiry < time()) {
            throw new CertificateException(sprintf('Certificate "%s" expired on %s.', $path, date(DATE_ATOM, $expiry)));
        }

        $this->certificate = $certResource;
        $this->privateKey = openssl_pkey_get_private($data['pkey'], $password);
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

    /**
     * Return certificate expiry timestamp or null if unknown.
     */
    private function getCertificateExpiryFromResource($certResource): ?int
    {
        $parsed = openssl_x509_parse($certResource);
        if ($parsed === false) {
            return null;
        }

        if (isset($parsed['validTo_time_t'])) {
            return (int) $parsed['validTo_time_t'];
        }

        if (isset($parsed['validTo'])) {
            $ts = strtotime($parsed['validTo']);
            return $ts === false ? null : $ts;
        }

        return null;
    }

    /**
     * Public helpers for application-level checks
     */
    public function getCertificateExpiry(): ?int
    {
        if (!$this->certificate) {
            return null;
        }
        return $this->getCertificateExpiryFromResource($this->certificate);
    }

    public function isCertificateExpired(): bool
    {
        $expiry = $this->getCertificateExpiry();
        return $expiry !== null && $expiry < time();
    }
}
