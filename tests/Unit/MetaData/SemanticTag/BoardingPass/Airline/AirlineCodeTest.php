<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\AirlineCode;
use PHPUnit\Framework\TestCase;

class AirlineCodeTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AirlineCode('KL123');

        self::assertSame('airlineCode', $semanticTag->getKey());
        self::assertSame('KL123', $semanticTag->getValue());
    }
}
