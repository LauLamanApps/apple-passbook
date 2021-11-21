<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractInteger;
use PHPUnit\Framework\TestCase;

class AbstractIntegerTest extends TestCase
{
    public function testGetValueReturnsInteger(): void
    {
        $semanticTag = new class(123) extends AbstractInteger {
            public function getKey(): string
            {
                return 'AbstractInteger';
            }
        };

        self::assertSame(123, $semanticTag->getValue());
    }
}