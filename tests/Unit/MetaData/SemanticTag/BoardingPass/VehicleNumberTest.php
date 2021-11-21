<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\VehicleNumber;
use PHPUnit\Framework\TestCase;

class VehicleNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VehicleNumber('A2B34');

        self::assertSame('vehicleNumber', $semanticTag->getKey());
        self::assertSame('A2B34', $semanticTag->getValue());
    }
}