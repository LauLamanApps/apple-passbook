<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\SecurityScreening;
use PHPUnit\Framework\TestCase;

class SecurityScreeningTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new SecurityScreening('Priority');

        self::assertSame('securityScreening', $semanticTag->getKey());
        self::assertSame('Priority', $semanticTag->getValue());
    }
}
