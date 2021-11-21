<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureTerminal;
use PHPUnit\Framework\TestCase;

class DepartureTerminalTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureTerminal('Terminal 3');

        self::assertSame('departureTerminal', $semanticTag->getKey());
        self::assertSame('Terminal 3', $semanticTag->getValue());
    }
}