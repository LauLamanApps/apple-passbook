<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\MembershipProgramStatus;
use PHPUnit\Framework\TestCase;

class MembershipProgramStatusTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new MembershipProgramStatus('Gold');

        self::assertSame('membershipProgramStatus', $semanticTag->getKey());
        self::assertSame('Gold', $semanticTag->getValue());
    }
}
