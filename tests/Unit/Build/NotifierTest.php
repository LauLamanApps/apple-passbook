<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\ApnsEnvironment;
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
    public function testConstructorAcceptsP12File(): void
    {
        $path = $this->createTempFile('.p12');

        try {
            $notifier = new Notifier($path, 'password');
            $this->assertInstanceOf(Notifier::class, $notifier);
        } finally {
            unlink($path);
        }
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorAcceptsPemFile(): void
    {
        $path = $this->createTempFile('.pem');

        try {
            $notifier = new Notifier($path);
            $this->assertInstanceOf(Notifier::class, $notifier);
        } finally {
            unlink($path);
        }
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorAcceptsEnvironment(): void
    {
        $path = $this->createTempFile('.p12');

        try {
            $notifier = new Notifier($path, 'password', ApnsEnvironment::Sandbox);
            $this->assertInstanceOf(Notifier::class, $notifier);
        } finally {
            unlink($path);
        }
    }

    private function createTempFile(string $extension): string
    {
        $path = sys_get_temp_dir() . '/test_passbook_cert_' . uniqid() . $extension;
        file_put_contents($path, 'dummy-certificate-content');

        return $path;
    }
}
