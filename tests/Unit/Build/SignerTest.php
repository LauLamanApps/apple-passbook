<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Exception\CertificateException;
use LauLamanApps\ApplePassbook\Build\Signer;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \LauLamanApps\ApplePassbook\Build\Signer
 */
class SignerTest extends TestCase
{
    /**
     * @covers ::setCertificate
     */
    public function testSetCertificateThrowsOnMissingFile(): void
    {
        $this->expectException(CertificateException::class);
        $this->expectExceptionMessage('Could not load certificate file');

        $signer = new Signer();
        $signer->setCertificate('/nonexistent/cert.p12', 'password');
    }

    /**
     * @covers ::setCertificate
     */
    public function testSetCertificateThrowsOnInvalidPkcs12(): void
    {
        $path = sys_get_temp_dir() . '/test_invalid_cert_' . uniqid() . '.p12';
        file_put_contents($path, 'not-a-certificate');

        try {
            $this->expectException(CertificateException::class);
            $this->expectExceptionMessage('Unable to read the certificate store');

            $signer = new Signer();
            $signer->setCertificate($path, 'password');
        } finally {
            unlink($path);
        }
    }

    /**
     * @covers ::setCertificate
     */
    public function testSetCertificateThrowsOnExpiredCertificate(): void
    {
        $path = $this->createExpiredP12();

        try {
            $this->expectException(CertificateException::class);
            $this->expectExceptionMessage('expired on');

            $signer = new Signer();
            $signer->setCertificate($path, 'test-password');
        } finally {
            @unlink($path);
        }
    }

    /**
     * @covers ::setCertificate
     */
    public function testSetCertificateAcceptsValidCertificate(): void
    {
        $path = $this->createValidP12();

        try {
            $signer = new Signer();
            $signer->setCertificate($path, 'test-password');
            $this->assertInstanceOf(Signer::class, $signer);
        } finally {
            unlink($path);
        }
    }

    /**
     * @covers ::setAppleWWDRCA
     */
    public function testSetAppleWWDRCAThrowsOnMissingFile(): void
    {
        $this->expectException(CertificateException::class);

        $signer = new Signer();
        $signer->setAppleWWDRCA('/nonexistent/ca.pem');
    }

    private function createExpiredP12(): string
    {
        $keyFile = tempnam(sys_get_temp_dir(), 'key_');
        $certFile = tempnam(sys_get_temp_dir(), 'cert_');
        $p12File = sys_get_temp_dir() . '/test_expired_' . uniqid() . '.p12';

        exec(sprintf('openssl genrsa -out %s 2048 2>&1', escapeshellarg($keyFile)));

        $startDate = date('YmdHis', strtotime('-2 days')) . 'Z';
        $endDate = date('YmdHis', strtotime('-1 day')) . 'Z';

        exec(sprintf(
            'openssl req -new -x509 -key %s -out %s -subj "/CN=Expired" -not_before %s -not_after %s 2>&1',
            escapeshellarg($keyFile),
            escapeshellarg($certFile),
            escapeshellarg($startDate),
            escapeshellarg($endDate),
        ));

        exec(sprintf(
            'openssl pkcs12 -export -in %s -inkey %s -out %s -passout pass:test-password 2>&1',
            escapeshellarg($certFile),
            escapeshellarg($keyFile),
            escapeshellarg($p12File),
        ));

        @unlink($keyFile);
        @unlink($certFile);

        return $p12File;
    }

    private function createValidP12(): string
    {
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        self::assertNotFalse($key);

        $csr = openssl_csr_new(['CN' => 'Valid Test'], $key);
        self::assertInstanceOf(\OpenSSLCertificateSigningRequest::class, $csr);

        $cert = openssl_csr_sign($csr, null, $key, 365);
        self::assertNotFalse($cert);

        $path = sys_get_temp_dir() . '/test_valid_cert_' . uniqid() . '.p12';
        openssl_pkcs12_export_to_file($cert, $path, $key, 'test-password');

        return $path;
    }
}
