<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventName;
use PHPUnit\Framework\TestCase;

class EventNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new EventName('Soul Survivor Festival');

        self::assertSame('eventName', $semanticTag->getKey());
        self::assertSame('Soul Survivor Festival', $semanticTag->getValue());
    }
}
