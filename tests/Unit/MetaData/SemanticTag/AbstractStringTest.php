<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;
use PHPUnit\Framework\TestCase;

class AbstractStringTest extends TestCase
{
    public function testGetValueReturnsInteger(): void
    {
        $semanticTag = new class('some string') extends AbstractString {
            public function getKey(): string
            {
                return 'AbstractString';
            }
        };

        self::assertSame('some string', $semanticTag->getValue());
    }
}
