<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueLocation;
use PHPUnit\Framework\TestCase;

class VenueLocationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VenueLocation(52.3122606, 4.9442166);

        self::assertSame('venueLocation', $semanticTag->getKey());
        self::assertSame(['latitude' => 52.3122606, 'longitude' => 4.9442166], $semanticTag->getValue());
    }
}
