<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\TransitProvider;
use PHPUnit\Framework\TestCase;

class TransitProviderTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new TransitProvider('KLM');

        self::assertSame('transitProvider', $semanticTag->getKey());
        self::assertSame('KLM', $semanticTag->getValue());
    }
}
