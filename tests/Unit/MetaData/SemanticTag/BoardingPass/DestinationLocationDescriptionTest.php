<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DestinationLocationDescription;
use PHPUnit\Framework\TestCase;

class DestinationLocationDescriptionTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationLocationDescription('Amsterdam');

        self::assertSame('destinationLocationDescription', $semanticTag->getKey());
        self::assertSame('Amsterdam', $semanticTag->getValue());
    }
}
