<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DepartureLocationDescription;
use PHPUnit\Framework\TestCase;

class DepartureLocationDescriptionTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureLocationDescription('Rotterdam');

        self::assertSame('departureLocationDescription', $semanticTag->getKey());
        self::assertSame('Rotterdam', $semanticTag->getValue());
    }
}
