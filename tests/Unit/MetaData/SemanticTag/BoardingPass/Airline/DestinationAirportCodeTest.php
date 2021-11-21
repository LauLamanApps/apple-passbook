<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DestinationAirportCode;
use PHPUnit\Framework\TestCase;

class DestinationAirportCodeTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationAirportCode('AMS');

        self::assertSame('destinationAirportCode', $semanticTag->getKey());
        self::assertSame('AMS', $semanticTag->getValue());
    }
}
