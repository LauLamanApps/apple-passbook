<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\MembershipProgramName;
use PHPUnit\Framework\TestCase;

class MembershipProgramNameTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new MembershipProgramName('Gold');

        self::assertSame('membershipProgramName', $semanticTag->getKey());
        self::assertSame('Gold', $semanticTag->getValue());
    }
}