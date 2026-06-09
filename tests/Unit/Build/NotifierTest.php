<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Exception\NotifierException;
use LauLamanApps\ApplePassbook\Build\Notifier;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \LauLamanApps\ApplePassbook\Build\Notifier
 */
class NotifierTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructorThrowsOnMissingCertificate(): void
    {
        $this->expectException(NotifierException::class);
        $this->expectExceptionMessage('Certificate file not found');

        new Notifier('/nonexistent/certificate.p12', 'password');
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorThrowsOnInvalidCertificate(): void
    {
        $certPath = sys_get_temp_dir() . '/test_invalid_cert.p12';
        file_put_contents($certPath, 'not-a-real-certificate');

        try {
            $this->expectException(NotifierException::class);
            $this->expectExceptionMessage('Failed to read PKCS12 certificate');

            new Notifier($certPath, 'wrong-password');
        } finally {
            unlink($certPath);
        }
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorWithValidCertificateCreatesPemFile(): void
    {
        $certPath = $this->createSelfSignedP12();

        try {
            $notifier = new Notifier($certPath, 'test-password');
            $this->assertInstanceOf(Notifier::class, $notifier);

            $pemPath = sys_get_temp_dir() . '/apple_passbook_push_' . md5($certPath) . '.pem';
            $this->assertFileExists($pemPath);

            $pemContent = file_get_contents($pemPath);
            $this->assertStringContainsString('-----BEGIN CERTIFICATE-----', $pemContent);
            $this->assertStringContainsString('-----BEGIN PRIVATE KEY-----', $pemContent);
        } finally {
            unlink($certPath);
        }
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorAcceptsSandboxFlag(): void
    {
        $certPath = $this->createSelfSignedP12();

        try {
            $notifier = new Notifier($certPath, 'test-password', sandbox: true);
            $this->assertInstanceOf(Notifier::class, $notifier);
        } finally {
            unlink($certPath);
        }
    }

    private function createSelfSignedP12(): string
    {
        $key = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        $csr = openssl_csr_new(['CN' => 'Test'], $key);
        $cert = openssl_csr_sign($csr, null, $key, 1);

        $path = sys_get_temp_dir() . '/test_passbook_cert_' . uniqid() . '.p12';
        openssl_pkcs12_export_to_file($cert, $path, $key, 'test-password');

        return $path;
    }
}
