<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Exception\CertificateException;
use LauLamanApps\ApplePassbook\Build\Signer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Signer::class)]
class SignerTest extends TestCase
{
    public function testSetCertificateThrowsOnMissingFile(): void
    {
        $this->expectException(CertificateException::class);
        $this->expectExceptionMessage('Could not load certificate file');

        $signer = new Signer();
        $signer->setCertificate('/nonexistent/cert.p12', 'password');
    }

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

    public function testSetCertificateThrowsOnExpiredCertificate(): void
    {
        $path = $this->createExpiredP12();

        if ($path === null) {
            $this->markTestSkipped('OpenSSL CLI does not support -not_before/-not_after flags (requires OpenSSL 3.x).');
        }

        try {
            $this->expectException(CertificateException::class);
            $this->expectExceptionMessage('expired on');

            $signer = new Signer();
            $signer->setCertificate($path, 'test-password');
        } finally {
            @unlink($path);
        }
    }

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

    public function testSetAppleWWDRCAThrowsOnMissingFile(): void
    {
        $this->expectException(CertificateException::class);

        $signer = new Signer();
        $signer->setAppleWWDRCA('/nonexistent/ca.pem');
    }

    public function testSignThrowsWhenNoCertificateConfigured(): void
    {
        $this->expectException(CertificateException::class);
        $this->expectExceptionMessage('No certificate configured');

        $signer = new Signer();
        $signer->sign(sys_get_temp_dir() . '/');
    }

    public function testDefaultAppleWWDRCAIsG3(): void
    {
        $signer = new Signer();

        self::assertStringEndsWith('AppleWWDRCAG3.pem', $signer->getAppleWWDRCA());
    }

    public function testAppleWWDRCAIsAutoSelectedFromCertificateIssuer(): void
    {
        $path = $this->createValidP12(['CN' => 'Valid Test', 'OU' => 'G6']);

        try {
            $signer = new Signer();
            $signer->setCertificate($path, 'test-password');

            self::assertStringEndsWith('AppleWWDRCAG6.pem', $signer->getAppleWWDRCA());
        } finally {
            unlink($path);
        }
    }

    public function testAppleWWDRCAKeepsDefaultWhenIssuerIsUnknown(): void
    {
        $path = $this->createValidP12();

        try {
            $signer = new Signer();
            $signer->setCertificate($path, 'test-password');

            self::assertStringEndsWith('AppleWWDRCAG3.pem', $signer->getAppleWWDRCA());
        } finally {
            unlink($path);
        }
    }

    public function testExplicitlySetAppleWWDRCAIsNotOverriddenByAutoSelection(): void
    {
        $customCa = __DIR__ . '/../../../certificates/AppleWWDRCAG4.pem';
        $path = $this->createValidP12(['CN' => 'Valid Test', 'OU' => 'G6']);

        try {
            $signer = new Signer();
            $signer->setAppleWWDRCA($customCa);
            $signer->setCertificate($path, 'test-password');

            self::assertSame($customCa, $signer->getAppleWWDRCA());
        } finally {
            unlink($path);
        }
    }

    private function createExpiredP12(): ?string
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
        ), $output, $certResult);

        if ($certResult !== 0) {
            @unlink($keyFile);
            @unlink($certFile);
            return null;
        }

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

    /**
     * @param array<string, string> $dn
     */
    private function createValidP12(array $dn = ['CN' => 'Valid Test']): string
    {
        $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        self::assertNotFalse($key);

        $csr = openssl_csr_new($dn, $key);
        self::assertInstanceOf(\OpenSSLCertificateSigningRequest::class, $csr);

        $cert = openssl_csr_sign($csr, null, $key, 365);
        self::assertNotFalse($cert);

        $path = sys_get_temp_dir() . '/test_valid_cert_' . uniqid() . '.p12';
        openssl_pkcs12_export_to_file($cert, $path, $key, 'test-password');

        return $path;
    }
}
