<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\OriginalBoardingDate;
use PHPUnit\Framework\TestCase;

class OriginalBoardingDateTest extends TestCase
{
    public function testGetValueReturnsIso8601String(): void
    {
        $semanticTag = new OriginalBoardingDate(new DateTimeImmutable('2007-04-22 14:43:21+200'));

        self::assertSame('originalBoardingDate', $semanticTag->getKey());
        self::assertSame('2007-04-22T14:43:21+0200', $semanticTag->getValue());
    }
}
