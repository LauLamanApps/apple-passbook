<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\AwayTeamName;
use PHPUnit\Framework\TestCase;

class AwayTeamNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AwayTeamName('Feyenoord Rotterdam');

        self::assertSame('awayTeamName', $semanticTag->getKey());
        self::assertSame('Feyenoord Rotterdam', $semanticTag->getValue());
    }
}