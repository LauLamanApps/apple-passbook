<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\HomeTeamLocation;
use PHPUnit\Framework\TestCase;

class HomeTeamLocationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new HomeTeamLocation('Amsterdam');

        self::assertSame('homeTeamLocation', $semanticTag->getKey());
        self::assertSame('Amsterdam', $semanticTag->getValue());
    }
}
