<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightCode;
use PHPUnit\Framework\TestCase;

class FlightCodeTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new FlightCode('KL123');

        self::assertSame('flightCode', $semanticTag->getKey());
        self::assertSame('KL123', $semanticTag->getValue());
    }
}
