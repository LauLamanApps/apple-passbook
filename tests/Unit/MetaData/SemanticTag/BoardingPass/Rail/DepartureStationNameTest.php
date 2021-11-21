<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail\DepartureStationName;
use PHPUnit\Framework\TestCase;

class DepartureStationNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureStationName('Amsterdam Centraal');

        self::assertSame('departureStationName', $semanticTag->getKey());
        self::assertSame('Amsterdam Centraal', $semanticTag->getValue());
    }
}