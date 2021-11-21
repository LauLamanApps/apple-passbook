<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractLocation;
use PHPUnit\Framework\TestCase;

class AbstractLocationTest extends TestCase
{
    public function testGetValueReturnsCurrencyArray(): void
    {
        $semanticTag = new class(52.3494545, 5.1514097) extends AbstractLocation {
            public function getKey(): string
            {
                return 'AbstractLocation';
            }
        };
        $expectedArray = [
            'latitude' => 52.3494545,
            'longitude' => 5.1514097,
        ];

        self::assertSame($expectedArray, $semanticTag->getValue());
    }
}
