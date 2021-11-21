<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail\DestinationStationName;
use PHPUnit\Framework\TestCase;

class DestinationStationNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationStationName('Rotterdam Centraal');

        self::assertSame('destinationStationName', $semanticTag->getKey());
        self::assertSame('Rotterdam Centraal', $semanticTag->getValue());
    }
}
