<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\Generic;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\TotalPrice;
use PHPUnit\Framework\TestCase;

class TotalPriceTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new TotalPrice('10.00', 'EUR');

        self::assertSame('totalPrice', $semanticTag->getKey());
    }
}