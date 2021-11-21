<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\AwayTeamAbbreviation;
use PHPUnit\Framework\TestCase;

class AwayTeamAbbreviationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AwayTeamAbbreviation('Feyenoord');

        self::assertSame('awayTeamAbbreviation', $semanticTag->getKey());
        self::assertSame('Feyenoord', $semanticTag->getValue());
    }
}