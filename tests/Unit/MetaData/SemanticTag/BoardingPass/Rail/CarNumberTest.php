<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail\CarNumber;
use PHPUnit\Framework\TestCase;

class CarNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new CarNumber('Wagon 5');

        self::assertSame('carNumber', $semanticTag->getKey());
        self::assertSame('Wagon 5', $semanticTag->getValue());
    }
}