<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\HomeTeamAbbreviation;
use PHPUnit\Framework\TestCase;

class HomeTeamAbbreviationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new HomeTeamAbbreviation('AFC Ajax');

        self::assertSame('homeTeamAbbreviation', $semanticTag->getKey());
        self::assertSame('AFC Ajax', $semanticTag->getValue());
    }
}