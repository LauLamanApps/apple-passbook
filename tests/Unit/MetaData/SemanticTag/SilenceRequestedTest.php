<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\SilenceRequested;
use PHPUnit\Framework\TestCase;

class SilenceRequestedTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new SilenceRequested();

        self::assertSame('silenceRequested', $semanticTag->getKey());
        self::assertTrue($semanticTag->getValue());
    }
}
