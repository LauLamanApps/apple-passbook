<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use LauLamanApps\ApplePassbook\MetaData\Location;
use PHPUnit\Framework\TestCase;

final class LocationTest extends TestCase
{
    public function testToArray(): void
    {
        $location = new Location(52.3494545, 5.1514097);

        $expected = [
            'latitude' => 52.3494545,
            'longitude' => 5.1514097,
        ];

        self::assertSame($expected, $location->toArray());
    }

    public function testSetAltitude(): void
    {
        $location = new Location(52.3494545, 5.1514097, -6.00);

        $expected = [
            'latitude' => 52.3494545,
            'longitude' => 5.1514097,
            'altitude' => -6.00
        ];

        self::assertSame($expected, $location->toArray());

        $location->setAltitude(0.00);

        $expected = [
            'latitude' => 52.3494545,
            'longitude' => 5.1514097,
            'altitude' => 0.00
        ];

        self::assertSame($expected, $location->toArray());
    }

    public function testSetRelevantText(): void
    {
        $location = new Location(52.3494545, 5.1514097);
        $location->setRelevantText('Welcome to Almere Poort');

        $expected = [
            'latitude' => 52.3494545,
            'longitude' => 5.1514097,
            'relevantText' => 'Welcome to Almere Poort',
        ];

        self::assertSame($expected, $location->toArray());
    }
}
