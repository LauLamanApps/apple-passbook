<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\BoardingGroup;
use PHPUnit\Framework\TestCase;

class BoardingGroupTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new BoardingGroup('Group A');

        self::assertSame('boardingGroup', $semanticTag->getKey());
        self::assertSame('Group A', $semanticTag->getValue());
    }
}