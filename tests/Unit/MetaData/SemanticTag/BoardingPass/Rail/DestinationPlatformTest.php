<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail\DestinationPlatform;
use PHPUnit\Framework\TestCase;

class DestinationPlatformTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new DestinationPlatform('Spoor 3');

        self::assertSame('destinationPlatform', $semanticTag->getKey());
        self::assertSame('Spoor 3', $semanticTag->getValue());
    }
}
