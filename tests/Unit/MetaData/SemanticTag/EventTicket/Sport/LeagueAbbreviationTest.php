<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\LeagueAbbreviation;
use PHPUnit\Framework\TestCase;

class LeagueAbbreviationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new LeagueAbbreviation('KNVB');

        self::assertSame('leagueAbbreviation', $semanticTag->getKey());
        self::assertSame('KNVB', $semanticTag->getValue());
    }
}
