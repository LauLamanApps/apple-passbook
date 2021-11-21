<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventStartDate;
use PHPUnit\Framework\TestCase;

class EventStartDateTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new EventStartDate(new DateTimeImmutable('2007-04-22 14:43:21+200'));

        self::assertSame('eventStartDate', $semanticTag->getKey());
        self::assertSame('2007-04-22T14:43:21+0200', $semanticTag->getValue());
    }
}
