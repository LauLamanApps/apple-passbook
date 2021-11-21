<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureGate;
use PHPUnit\Framework\TestCase;

class DepartureGateTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureGate('M7');

        self::assertSame('departureGate', $semanticTag->getKey());
        self::assertSame('M7', $semanticTag->getValue());
    }
}
