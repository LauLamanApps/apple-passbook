<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DestinationAirportName;
use PHPUnit\Framework\TestCase;

class DestinationAirportNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationAirportName('Amsterdam Airport Schiphol');

        self::assertSame('destinationAirportName', $semanticTag->getKey());
        self::assertSame('Amsterdam Airport Schiphol', $semanticTag->getValue());
    }
}
