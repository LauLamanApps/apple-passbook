<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\AdmissionLevel;
use PHPUnit\Framework\TestCase;

class AdmissionLevelTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new AdmissionLevel('VIP');

        self::assertSame('admissionLevel', $semanticTag->getKey());
        self::assertSame('VIP', $semanticTag->getValue());
    }
}
