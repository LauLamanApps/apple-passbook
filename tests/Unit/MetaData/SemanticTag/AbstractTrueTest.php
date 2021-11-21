<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractTrue;
use PHPUnit\Framework\TestCase;

class AbstractTrueTest extends TestCase
{
    public function testGetValueReturnsInteger(): void
    {
        $semanticTag = new class() extends AbstractTrue {
            public function getKey(): string
            {
                return 'AbstractTrue';
            }
        };

        self::assertTrue($semanticTag->getValue());
    }
}