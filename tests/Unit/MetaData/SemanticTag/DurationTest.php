<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Duration;
use PHPUnit\Framework\TestCase;

class DurationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new Duration(123);

        self::assertSame('duration', $semanticTag->getKey());
        self::assertSame(123, $semanticTag->getValue());
    }
}