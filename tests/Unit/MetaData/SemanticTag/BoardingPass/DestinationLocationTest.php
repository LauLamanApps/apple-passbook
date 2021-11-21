<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DestinationLocation;
use PHPUnit\Framework\TestCase;

class DestinationLocationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationLocation(52.3727598, 4.8936041);

        self::assertSame('destinationLocation', $semanticTag->getKey());
        self::assertSame(['latitude' => 52.3727598, 'longitude' => 4.8936041], $semanticTag->getValue());
    }
}
