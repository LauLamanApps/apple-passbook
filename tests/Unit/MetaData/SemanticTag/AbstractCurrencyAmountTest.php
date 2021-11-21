<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractCurrencyAmount;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractDate;
use PHPUnit\Framework\TestCase;

class AbstractCurrencyAmountTest extends TestCase
{
    public function testGetValueReturnsCurrencyArray(): void
    {
        $semanticTag = new class('10.00','EUR') extends AbstractCurrencyAmount {
            public function getKey(): string
            {
                return 'AbstractCurrencyAmount';
            }
        };
        $expectedArray = [
            'amount' => '10.00',
            'currencyCode' => 'EUR',
        ];

        self::assertSame($expectedArray, $semanticTag->getValue());
    }


}