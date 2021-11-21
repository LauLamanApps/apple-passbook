<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\SportName;
use PHPUnit\Framework\TestCase;

class SportNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new SportName('Elfstedentocht');

        self::assertSame('sportName', $semanticTag->getKey());
        self::assertSame('Elfstedentocht', $semanticTag->getValue());
    }
}