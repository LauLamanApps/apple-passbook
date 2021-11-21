<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\VehicleName;
use PHPUnit\Framework\TestCase;

class VehicleNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VehicleName('Boat 12');

        self::assertSame('vehicleName', $semanticTag->getKey());
        self::assertSame('Boat 12', $semanticTag->getValue());
    }
}
