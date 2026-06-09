<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueDoorsOpenDate;
use PHPUnit\Framework\TestCase;

class VenueDoorsOpenDateTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $date = new DateTimeImmutable();
        $semanticTag = new VenueDoorsOpenDate($date);

        self::assertSame('venueDoorsOpenDate', $semanticTag->getKey());
        self::assertSame($date->format(DateTimeInterface::ISO8601), $semanticTag->getValue());
    }
}
