<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\ArtistIDs;
use PHPUnit\Framework\TestCase;

class ArtistIDsTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new ArtistIDs('<ArtistID-1>');

        self::assertEquals(['<ArtistID-1>'], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new ArtistIDs();

        self::assertEquals('artistIDs', $semanticTag->getKey());
    }

    public function testAddSeat(): void
    {
        $semanticTag = new ArtistIDs();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->addArtistId('<ArtistID-1>');
        self::assertEquals(['<ArtistID-1>'], $semanticTag->getValue());

        $semanticTag->addArtistId('<ArtistID-2>');
        self::assertEquals(['<ArtistID-1>', '<ArtistID-2>'], $semanticTag->getValue());
    }
}
