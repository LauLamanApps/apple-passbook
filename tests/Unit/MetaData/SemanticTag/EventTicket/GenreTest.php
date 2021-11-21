<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Genre;
use PHPUnit\Framework\TestCase;

class GenreTest extends TestCase
{
    public function testSemanticTag(): void
    {
        $semanticTag = new Genre('EDM');

        self::assertSame('genre', $semanticTag->getKey());
        self::assertSame('EDM', $semanticTag->getValue());
    }
}