<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\TransitStatusReason;
use PHPUnit\Framework\TestCase;

class TransitStatusReasonTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new TransitStatusReason('Thunderstorms');

        self::assertSame('transitStatusReason', $semanticTag->getKey());
        self::assertSame('Thunderstorms', $semanticTag->getValue());
    }
}