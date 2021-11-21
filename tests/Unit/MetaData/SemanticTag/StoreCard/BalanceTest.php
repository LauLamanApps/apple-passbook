<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\StoreCard;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\StoreCard\Balance;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new Balance('10.00', 'EUR');

        self::assertSame('balance', $semanticTag->getKey());
    }
}