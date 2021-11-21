<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\BoardingSequenceNumber;
use PHPUnit\Framework\TestCase;

class BoardingSequenceNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new BoardingSequenceNumber('A');

        self::assertSame('boardingSequenceNumber', $semanticTag->getKey());
        self::assertSame('A', $semanticTag->getValue());
    }
}