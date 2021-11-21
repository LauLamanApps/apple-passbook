<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenuePhoneNumber;
use PHPUnit\Framework\TestCase;

class VenuePhoneNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VenuePhoneNumber('+31 (0)6 12 34 56 78');

        self::assertSame('venuePhoneNumber', $semanticTag->getKey());
        self::assertSame('+31 (0)6 12 34 56 78', $semanticTag->getValue());
    }
}
