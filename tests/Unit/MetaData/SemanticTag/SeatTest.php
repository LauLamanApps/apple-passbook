<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seat;
use PHPUnit\Framework\TestCase;

class SeatTest extends TestCase
{
    public function testDescription(): void
    {
        $seat = new Seat('<description>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatDescription', $data);
        self::assertEquals('<description>', $data['seatDescription']);
    }

    public function testIdentifier(): void
    {
        $seat = new Seat(null, '<identifier>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatIdentifier', $data);
        self::assertEquals('<identifier>', $data['seatIdentifier']);
    }

    public function testNumber(): void
    {
        $seat = new Seat(null, null, '<number>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatNumber', $data);
        self::assertEquals('<number>', $data['seatNumber']);
    }

    public function testRow(): void
    {
        $seat = new Seat(null, null, null, '<row>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatRow', $data);
        self::assertEquals('<row>', $data['seatRow']);
    }

    public function testSection(): void
    {
        $seat = new Seat(null, null, null, null, '<section>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatSection', $data);
        self::assertEquals('<section>', $data['seatSection']);
    }

    public function testType(): void
    {
        $seat = new Seat(null, null, null, null, null, '<type>');

        $data = $seat->getValue();

        self::assertArrayHasKey('seatType', $data);
        self::assertEquals('<type>', $data['seatType']);
    }
}
