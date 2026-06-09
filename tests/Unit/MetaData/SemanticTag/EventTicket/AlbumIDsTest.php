<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\AlbumIDs;
use PHPUnit\Framework\TestCase;

class AlbumIDsTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new AlbumIDs('album-1');

        self::assertEquals(['album-1'], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new AlbumIDs();

        self::assertEquals('albumIDs', $semanticTag->getKey());
    }

    public function testAdd(): void
    {
        $semanticTag = new AlbumIDs();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->add('album-1');
        self::assertEquals(['album-1'], $semanticTag->getValue());

        $semanticTag->add('album-2');
        self::assertEquals(['album-1', 'album-2'], $semanticTag->getValue());
    }
}
