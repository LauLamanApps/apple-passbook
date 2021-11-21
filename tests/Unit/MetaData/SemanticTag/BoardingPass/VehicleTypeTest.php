<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\VehicleType;
use PHPUnit\Framework\TestCase;

class VehicleTypeTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VehicleType('SLT-6');

        self::assertSame('vehicleType', $semanticTag->getKey());
        self::assertSame('SLT-6', $semanticTag->getValue());
    }
}