<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\ConfirmationNumber;
use PHPUnit\Framework\TestCase;

class ConfirmationNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new ConfirmationNumber('ABC123');

        self::assertSame('confirmationNumber', $semanticTag->getKey());
        self::assertSame('ABC123', $semanticTag->getValue());
    }
}
