<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\MembershipProgramNumber;
use PHPUnit\Framework\TestCase;

class MembershipProgramNumberTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new MembershipProgramNumber('GOLD-1234-5678');

        self::assertSame('membershipProgramNumber', $semanticTag->getKey());
        self::assertSame('GOLD-1234-5678', $semanticTag->getValue());
    }
}
