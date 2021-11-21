<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DestinationGate;
use PHPUnit\Framework\TestCase;

class DestinationGateTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationGate('M7');

        self::assertSame('destinationGate', $semanticTag->getKey());
        self::assertSame('M7', $semanticTag->getValue());
    }
}