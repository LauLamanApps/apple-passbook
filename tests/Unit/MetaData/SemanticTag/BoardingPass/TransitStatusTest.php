<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\TransitStatus;
use PHPUnit\Framework\TestCase;

class TransitStatusTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new TransitStatus('On Time');

        self::assertSame('transitStatus', $semanticTag->getKey());
        self::assertSame('On Time', $semanticTag->getValue());
    }
}
