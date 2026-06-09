<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use LauLamanApps\ApplePassbook\MetaData\Beacon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BeaconTest extends TestCase
{
    public function testConstruct(): void
    {
        $uuid = 'd286295b-0107-4ad2-a881-8adc06e98251';

        $beacon = new Beacon(Uuid::fromString($uuid));

        self::assertEquals(['proximityUUID' => $uuid], $beacon->toArray());
    }

    public function testSetMinorIdentifier(): void
    {
        $uuid = Uuid::uuid4();

        $beacon = new Beacon($uuid);
        $beacon->setMinorIdentifier(123);

        $expected = [
            'proximityUUID' => $uuid->toString(),
            'minor' => 123
        ];

        self::assertEquals($expected, $beacon->toArray());
    }

    public function testSetMajorIdentifier(): void
    {
        $uuid = Uuid::uuid4();

        $beacon = new Beacon($uuid);
        $beacon->setMajorIdentifier(456);

        $expected = [
            'proximityUUID' => $uuid->toString(),
            'major' => 456
        ];

        self::assertEquals($expected, $beacon->toArray());
    }
    public function testSetRelevantText(): void
    {
        $uuid = Uuid::uuid4();

        $beacon = new Beacon($uuid);
        $beacon->setRelevantText('<relevantText>');

        $expected = [
            'proximityUUID' => $uuid->toString(),
            'relevantText' => '<relevantText>'
        ];

        self::assertEquals($expected, $beacon->toArray());
    }
}
