<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueEntrance;
use PHPUnit\Framework\TestCase;

class VenueEntranceTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VenueEntrance('Main entrance');

        self::assertSame('venueEntrance', $semanticTag->getKey());
        self::assertSame('Main entrance', $semanticTag->getValue());
    }
}
