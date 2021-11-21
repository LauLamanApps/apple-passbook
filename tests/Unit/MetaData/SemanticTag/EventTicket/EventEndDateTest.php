<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventEndDate;
use PHPUnit\Framework\TestCase;

class EventEndDateTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new EventEndDate(new DateTimeImmutable('2007-04-22 14:43:21+200'));

        self::assertSame('eventEndDate', $semanticTag->getKey());
        self::assertSame('2007-04-22T14:43:21+0200', $semanticTag->getValue());
    }
}