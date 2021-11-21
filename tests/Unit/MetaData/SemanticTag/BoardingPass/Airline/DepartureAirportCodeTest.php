<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureAirportCode;
use PHPUnit\Framework\TestCase;

class DepartureAirportCodeTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureAirportCode('AMS');

        self::assertSame('departureAirportCode', $semanticTag->getKey());
        self::assertSame('AMS', $semanticTag->getValue());
    }
}
