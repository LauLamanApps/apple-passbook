<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DepartureLocation;
use PHPUnit\Framework\TestCase;

class DepartureLocationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureLocation(51.9244424, 4.47775);

        self::assertSame('departureLocation', $semanticTag->getKey());
        self::assertSame(['latitude' => 51.9244424, 'longitude' => 4.47775], $semanticTag->getValue());
    }
}