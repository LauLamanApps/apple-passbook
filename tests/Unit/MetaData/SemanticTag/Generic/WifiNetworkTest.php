<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\Generic;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiNetwork;
use PHPUnit\Framework\TestCase;

class WifiNetworkTest extends TestCase
{
    public function testGetValueReturnsCurrencyArray(): void
    {
        $semanticTag = new WifiNetwork('Free WiFi', 'U!tr@$3cr3tP@$$w0rd');
        $expectedArray = [
            'ssid' => 'Free WiFi',
            'password' => 'U!tr@$3cr3tP@$$w0rd',
        ];

        self::assertSame($expectedArray, $semanticTag->getValue());
    }
}