<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\TicketFareClass;
use PHPUnit\Framework\TestCase;

class TicketFareClassTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new TicketFareClass('Economy');

        self::assertSame('ticketFareClass', $semanticTag->getKey());
        self::assertSame('Economy', $semanticTag->getValue());
    }
}
