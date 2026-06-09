<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DepartureCityName;
use PHPUnit\Framework\TestCase;

class DepartureCityNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DepartureCityName('London');

        self::assertSame('departureCityName', $semanticTag->getKey());
        self::assertSame('London', $semanticTag->getValue());
    }
}
