<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\ApnsEnvironment;
use LauLamanApps\ApplePassbook\Build\Exception\NotifierException;
use LauLamanApps\ApplePassbook\Build\Notifier;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Notifier::class)]
class NotifierTest extends TestCase
{
    public function testConstructorThrowsOnMissingCertificate(): void
    {
        $this->expectException(NotifierException::class);
        $this->expectExceptionMessage('Certificate file not found');

        new Notifier('/nonexistent/certificate.p12', 'password');
    }

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

    public function testNotifyThrowsOnNonHexadecimalPushToken(): void
    {
        $path = $this->createTempFile('.pem');

        try {
            $this->expectException(NotifierException::class);
            $this->expectExceptionMessage('push token is invalid');

            $notifier = new Notifier($path);
            $notifier->notify('../not-a-token');
        } finally {
            unlink($path);
        }
    }

    public function testNotifyThrowsOnEmptyPushToken(): void
    {
        $path = $this->createTempFile('.pem');

        try {
            $this->expectException(NotifierException::class);
            $this->expectExceptionMessage('push token is invalid');

            $notifier = new Notifier($path);
            $notifier->notify('');
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
