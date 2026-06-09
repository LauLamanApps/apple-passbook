<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\BoardingZone;
use PHPUnit\Framework\TestCase;

class BoardingZoneTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new BoardingZone('Zone A');

        self::assertSame('boardingZone', $semanticTag->getKey());
        self::assertSame('Zone A', $semanticTag->getValue());
    }
}
