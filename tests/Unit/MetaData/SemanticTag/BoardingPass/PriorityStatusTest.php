<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\PriorityStatus;
use PHPUnit\Framework\TestCase;

class PriorityStatusTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new PriorityStatus('Platinum');

        self::assertSame('priorityStatus', $semanticTag->getKey());
        self::assertSame('Platinum', $semanticTag->getValue());
    }
}