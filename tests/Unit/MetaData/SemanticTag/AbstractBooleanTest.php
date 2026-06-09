<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractBoolean;
use PHPUnit\Framework\TestCase;

class AbstractBooleanTest extends TestCase
{
    public function testGetValueReturnsTrue(): void
    {
        $semanticTag = new class(true) extends AbstractBoolean {
            public function getKey(): string
            {
                return 'AbstractBoolean';
            }
        };

        self::assertTrue($semanticTag->getValue());
    }

    public function testGetValueReturnsFalse(): void
    {
        $semanticTag = new class(false) extends AbstractBoolean {
            public function getKey(): string
            {
                return 'AbstractBoolean';
            }
        };

        self::assertFalse($semanticTag->getValue());
    }
}
