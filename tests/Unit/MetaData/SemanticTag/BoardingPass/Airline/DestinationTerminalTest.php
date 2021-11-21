<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DestinationTerminal;
use PHPUnit\Framework\TestCase;

class DestinationTerminalTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationTerminal('Terminal 3');

        self::assertSame('destinationTerminal', $semanticTag->getKey());
        self::assertSame('Terminal 3', $semanticTag->getValue());
    }
}
