<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureAirportName;
use PHPUnit\Framework\TestCase;

class DepartureAirportNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureAirportName('Amsterdam Airport Schiphol');

        self::assertSame('departureAirportName', $semanticTag->getKey());
        self::assertSame('Amsterdam Airport Schiphol', $semanticTag->getValue());
    }
}