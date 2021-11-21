<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\LeagueName;
use PHPUnit\Framework\TestCase;

class LeagueNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new LeagueName('Eredivisie');

        self::assertSame('leagueName', $semanticTag->getKey());
        self::assertSame('Eredivisie', $semanticTag->getValue());
    }
}