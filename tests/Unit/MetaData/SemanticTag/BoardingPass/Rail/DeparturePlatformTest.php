<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail\DeparturePlatform;
use PHPUnit\Framework\TestCase;

class DeparturePlatformTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DeparturePlatform('Spoor 13');

        self::assertSame('departurePlatform', $semanticTag->getKey());
        self::assertSame('Spoor 13', $semanticTag->getValue());
    }
}
