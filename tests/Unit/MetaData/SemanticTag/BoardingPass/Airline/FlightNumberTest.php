<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightNumber;
use PHPUnit\Framework\TestCase;

class FlightNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new FlightNumber(123);

        self::assertSame('flightNumber', $semanticTag->getKey());
        self::assertSame(123, $semanticTag->getValue());
    }
}
