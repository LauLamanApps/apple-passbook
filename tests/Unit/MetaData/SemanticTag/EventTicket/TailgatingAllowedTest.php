<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\TailgatingAllowed;
use PHPUnit\Framework\TestCase;

class TailgatingAllowedTest extends TestCase
{
    public function testSemanticTagTrue(): void
    {
        $semanticTag = new TailgatingAllowed(true);

        self::assertSame('tailgatingAllowed', $semanticTag->getKey());
        self::assertTrue($semanticTag->getValue());
    }

    public function testSemanticTagFalse(): void
    {
        $semanticTag = new TailgatingAllowed(false);

        self::assertSame('tailgatingAllowed', $semanticTag->getKey());
        self::assertFalse($semanticTag->getValue());
    }
}
