<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\AwayTeamLocation;
use PHPUnit\Framework\TestCase;

class AwayTeamLocationTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AwayTeamLocation('Rotterdam');

        self::assertSame('awayTeamLocation', $semanticTag->getKey());
        self::assertSame('Rotterdam', $semanticTag->getValue());
    }
}