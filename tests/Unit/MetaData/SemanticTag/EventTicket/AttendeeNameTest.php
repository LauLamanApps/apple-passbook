<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\AttendeeName;
use PHPUnit\Framework\TestCase;

class AttendeeNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AttendeeName('John Doe');

        self::assertSame('attendeeName', $semanticTag->getKey());
        self::assertSame('John Doe', $semanticTag->getValue());
    }
}
