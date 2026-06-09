<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractStringArray;
use PHPUnit\Framework\TestCase;

class AbstractStringArrayTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new class('some string') extends AbstractStringArray {
            public function getKey(): string
            {
                return 'AbstractStringArray';
            }
        };

        self::assertEquals(['some string'], $semanticTag->getValue());
    }

    public function testEmptyConstructor(): void
    {
        $semanticTag = new class() extends AbstractStringArray {
            public function getKey(): string
            {
                return 'AbstractStringArray';
            }
        };

        self::assertEquals([], $semanticTag->getValue());
    }

    public function testAdd(): void
    {
        $semanticTag = new class() extends AbstractStringArray {
            public function getKey(): string
            {
                return 'AbstractStringArray';
            }
        };

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->add('value1');
        self::assertEquals(['value1'], $semanticTag->getValue());

        $semanticTag->add('value2');
        self::assertEquals(['value1', 'value2'], $semanticTag->getValue());
    }
}
