<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueName;
use PHPUnit\Framework\TestCase;

class VenueNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new VenueName('Heineken Music Hall');

        self::assertSame('venueName', $semanticTag->getKey());
        self::assertSame('Heineken Music Hall', $semanticTag->getValue());
    }
}