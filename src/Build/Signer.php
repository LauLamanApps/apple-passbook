<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\CertificateException;

class Signer
{
    public const FILENAME = 'signature';

    private const CERTIFICATE_DIRECTORY = __DIR__ . '/../../certificates/';
    private const DEFAULT_WWDR_CA = self::CERTIFICATE_DIRECTORY . 'AppleWWDRCAG3.pem';

    private \OpenSSLCertificate $certificate;
    private \OpenSSLAsymmetricKey $privateKey;
    private string $appleWWDRCA = self::DEFAULT_WWDR_CA;
    private bool $appleWWDRCAExplicitlySet = false;

    /**
     * @throws CertificateException
     */
    public function __construct(?string $certificatePath = null, #[\SensitiveParameter] ?string $password = null)
    {
        if ($certificatePath !== null && $password !== null) {
            $this->setCertificate($certificatePath, $password);
        }
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

        if (!$this->appleWWDRCAExplicitlySet) {
            $this->autoSelectAppleWWDRCA($certificate);
        }
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
        $this->appleWWDRCAExplicitlySet = true;
    }

    public function getAppleWWDRCA(): string
    {
        return $this->appleWWDRCA;
    }

    /**
     * @throws CertificateException
     */
    public function sign(string $temporaryDirectory): void
    {
        if (!isset($this->certificate) || !isset($this->privateKey)) {
            throw CertificateException::noCertificateConfigured();
        }

        $manifestFile = $temporaryDirectory . ManifestGenerator::FILENAME;
        $signatureFile = $temporaryDirectory . self::FILENAME;

        $signed = openssl_pkcs7_sign(
            $manifestFile,
            $signatureFile,
            $this->certificate,
            $this->privateKey,
            [],
            PKCS7_BINARY | PKCS7_DETACHED,
            $this->appleWWDRCA
        );

        $signature = $signed ? file_get_contents($signatureFile) : false;
        if ($signature === false || $signature === '') {
            throw CertificateException::signingFailed();
        }

        $signature = $this->convertPEMtoDER($signature);
        file_put_contents($signatureFile, $signature);
    }

    /**
     * Selects the bundled Apple WWDR intermediate certificate matching the
     * issuer of the pass type identifier certificate (e.g. G3, G4, G6).
     */
    private function autoSelectAppleWWDRCA(\OpenSSLCertificate $certificate): void
    {
        $parsed = openssl_x509_parse($certificate);
        if ($parsed === false || !isset($parsed['issuer']['OU']) || !is_string($parsed['issuer']['OU'])) {
            return;
        }

        if (preg_match('/^G\d+$/', $parsed['issuer']['OU']) !== 1) {
            return;
        }

        $bundledCertificate = self::CERTIFICATE_DIRECTORY . sprintf('AppleWWDRCA%s.pem', $parsed['issuer']['OU']);
        if (file_exists($bundledCertificate)) {
            $this->appleWWDRCA = $bundledCertificate;
        }
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
