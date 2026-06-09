<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\InternationalDocumentsAreVerified;
use PHPUnit\Framework\TestCase;

class InternationalDocumentsAreVerifiedTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new InternationalDocumentsAreVerified(true);

        self::assertSame('internationalDocumentsAreVerified', $semanticTag->getKey());
        self::assertTrue($semanticTag->getValue());
    }
}
