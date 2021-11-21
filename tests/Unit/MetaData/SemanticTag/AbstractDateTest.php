<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractDate;
use PHPUnit\Framework\TestCase;

class AbstractDateTest extends TestCase
{
    public function testGetValueReturnsIso8601String(): void
    {
        $dateTime = new DateTimeImmutable();

        $semanticTag = new class($dateTime) extends AbstractDate {
            public function getKey(): string
            {
                return 'AbstractDate';
            }
        };

        self::assertSame($dateTime->format(DateTimeInterface::ISO8601), $semanticTag->getValue());
    }
}
