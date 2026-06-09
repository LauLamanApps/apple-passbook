<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\LoungePlaceIDs;
use PHPUnit\Framework\TestCase;

class LoungePlaceIDsTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new LoungePlaceIDs('place1');

        self::assertEquals(['place1'], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new LoungePlaceIDs();

        self::assertEquals('loungePlaceIDs', $semanticTag->getKey());
    }

    public function testAdd(): void
    {
        $semanticTag = new LoungePlaceIDs();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->add('place1');
        self::assertEquals(['place1'], $semanticTag->getValue());

        $semanticTag->add('place2');
        self::assertEquals(['place1', 'place2'], $semanticTag->getValue());
    }
}
