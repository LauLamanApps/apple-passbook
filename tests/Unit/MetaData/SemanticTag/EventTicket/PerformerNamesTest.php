<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\PerformerNames;
use PHPUnit\Framework\TestCase;

class PerformerNamesTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new PerformerNames('<performer-1>');

        self::assertEquals(['<performer-1>'], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new PerformerNames();

        self::assertEquals('performerNames', $semanticTag->getKey());
    }

    public function testAddSeat(): void
    {
        $semanticTag = new PerformerNames();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->addPerformer('<performer-1>');
        self::assertEquals(['<performer-1>'], $semanticTag->getValue());

        $semanticTag->addPerformer('<performer-2>');
        self::assertEquals(['<performer-1>', '<performer-2>'], $semanticTag->getValue());
    }
}