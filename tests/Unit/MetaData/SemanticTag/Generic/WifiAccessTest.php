<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\Generic;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiNetwork;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiAccess;
use PHPUnit\Framework\TestCase;

class WifiAccessTest extends TestCase
{
    public function testConstructor(): void
    {
        $wifiNetwork = $this->createMock(WifiNetwork::class);
        $wifiNetwork->expects($this->once())->method('getValue')->willReturn(['<wifi-network-1>']);

        $semanticTag = new WifiAccess($wifiNetwork);

        self::assertEquals([['<wifi-network-1>']], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new WifiAccess();

        self::assertEquals('wifiAccess', $semanticTag->getKey());
    }

    public function testAddWifiNetwork(): void
    {
        $semanticTag = new WifiAccess();

        self::assertEquals([], $semanticTag->getValue());

        $wifiNetwork1 = $this->createMock(WifiNetwork::class);
        $wifiNetwork1->expects($this->atLeastOnce())->method('getValue')->willReturn(['<wifi-network-1>']);

        $semanticTag->addWifiNetwork($wifiNetwork1);
        self::assertEquals([['<wifi-network-1>']], $semanticTag->getValue());

        $wifiNetwork2 = $this->createMock(WifiNetwork::class);
        $wifiNetwork2->expects($this->atLeastOnce())->method('getValue')->willReturn(['<wifi-network-2>']);

        $semanticTag->addWifiNetwork($wifiNetwork2);
        self::assertEquals([['<wifi-network-1>'], ['<wifi-network-2>']], $semanticTag->getValue());
    }
}