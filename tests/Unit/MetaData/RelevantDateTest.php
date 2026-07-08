<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\RelevantDate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RelevantDate::class)]
final class RelevantDateTest extends TestCase
{
    public function testForDate(): void
    {
        $relevantDate = RelevantDate::forDate(new DateTimeImmutable('2026-07-07T20:00:00+02:00'));

        self::assertSame(['date' => '2026-07-07T20:00:00+02:00'], $relevantDate->toArray());
    }

    public function testForInterval(): void
    {
        $relevantDate = RelevantDate::forInterval(
            new DateTimeImmutable('2026-07-07T18:00:00+02:00'),
            new DateTimeImmutable('2026-07-07T23:00:00+02:00')
        );

        self::assertSame(
            [
                'startDate' => '2026-07-07T18:00:00+02:00',
                'endDate' => '2026-07-07T23:00:00+02:00',
            ],
            $relevantDate->toArray()
        );
    }

    public function testForIntervalThrowsWhenEndDateIsBeforeStartDate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RelevantDate::forInterval(
            new DateTimeImmutable('2026-07-07T23:00:00+02:00'),
            new DateTimeImmutable('2026-07-07T18:00:00+02:00')
        );
    }
}
