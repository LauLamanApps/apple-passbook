<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport\HomeTeamName;
use PHPUnit\Framework\TestCase;

class HomeTeamNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new HomeTeamName('Amsterdamsche Football Club Ajax');

        self::assertSame('homeTeamName', $semanticTag->getKey());
        self::assertSame('Amsterdamsche Football Club Ajax', $semanticTag->getValue());
    }
}
