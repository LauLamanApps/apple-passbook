<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seat;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seats;
use PHPUnit\Framework\TestCase;

class SeatsTest extends TestCase
{
    public function testConstructor(): void
    {
        $seat = $this->createMock(Seat::class);
        $seat->expects($this->once())->method('getValue')->willReturn(['<seat-1>']);

        $semanticTag = new Seats($seat);

        self::assertEquals([['<seat-1>']], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new Seats();

        self::assertEquals('seats', $semanticTag->getKey());
    }

    public function testAddSeat(): void
    {
        $semanticTag = new Seats();

        self::assertEquals([], $semanticTag->getValue());

        $seat1 = $this->createMock(Seat::class);
        $seat1->expects($this->atLeastOnce())->method('getValue')->willReturn(['<seat-1>']);

        $semanticTag->addSeat($seat1);
        self::assertEquals([['<seat-1>']], $semanticTag->getValue());

        $seat2 = $this->createMock(Seat::class);
        $seat2->expects($this->atLeastOnce())->method('getValue')->willReturn(['<seat-2>']);

        $semanticTag->addSeat($seat2);
        self::assertEquals([['<seat-1>'], ['<seat-2>']], $semanticTag->getValue());
    }
}
