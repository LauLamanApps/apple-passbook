<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueRoom;
use PHPUnit\Framework\TestCase;

class VenueRoomTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VenueRoom('Room 7');

        self::assertSame('venueRoom', $semanticTag->getKey());
        self::assertSame('Room 7', $semanticTag->getValue());
    }
}