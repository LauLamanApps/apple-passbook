<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventStartDateInfo;
use PHPUnit\Framework\TestCase;

class EventStartDateInfoTest extends TestCase
{
    public function testGetKey(): void
    {
        $date = new DateTimeImmutable();
        $semanticTag = new EventStartDateInfo($date);

        self::assertSame('eventStartDateInfo', $semanticTag->getKey());
    }

    public function testBasicValue(): void
    {
        $date = new DateTimeImmutable();
        $semanticTag = new EventStartDateInfo($date);

        self::assertEquals(['startDate' => $date->format(DateTimeInterface::ISO8601)], $semanticTag->getValue());
    }

    public function testWithTimeZoneAndStatus(): void
    {
        $date = new DateTimeImmutable();
        $semanticTag = new EventStartDateInfo($date);
        $semanticTag->setTimeZone('America/New_York');
        $semanticTag->setStatus('onTime');

        self::assertEquals([
            'startDate' => $date->format(DateTimeInterface::ISO8601),
            'timeZone' => 'America/New_York',
            'status' => 'onTime',
        ], $semanticTag->getValue());
    }
}
