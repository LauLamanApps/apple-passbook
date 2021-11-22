<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use LauLamanApps\ApplePassbook\MetaData\Nfc;
use PHPUnit\Framework\TestCase;

class NfcTest extends TestCase
{
    public function testBasicNfcObject(): void
    {
        $nfc = new Nfc('<encryptionPublicKey>', '<message>');

        self::assertArrayHasKey('encryptionPublicKey', $nfc->toArray());
        self::assertArrayHasKey('message', $nfc->toArray());
        self::assertArrayNotHasKey('requiresAuthentication', $nfc->toArray());

        self::assertEquals(['encryptionPublicKey' => '<encryptionPublicKey>', 'message' => '<message>'], $nfc->toArray());
    }

    public function testRequireAuthentication(): void
    {
        $nfc = new Nfc('<encryptionPublicKey>', '<message>');
        self::assertArrayNotHasKey('requiresAuthentication', $nfc->toArray());

        $nfc->requireAuthentication();

        self::assertTrue($nfc->requiresAuthentication());
        self::assertArrayHasKey('requiresAuthentication', $nfc->toArray());
        self::assertEquals(['encryptionPublicKey' => '<encryptionPublicKey>', 'message' => '<message>', 'requiresAuthentication' => true], $nfc->toArray());
    }
}
