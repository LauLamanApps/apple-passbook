<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;

class RelevantDate
{
    /**
     * @param array<string, string> $data
     */
    private function __construct(private readonly array $data)
    {
    }

    public static function forDate(DateTimeImmutable $date): self
    {
        return new self(['date' => $date->format(DateTimeInterface::W3C)]);
    }

    public static function forInterval(DateTimeImmutable $startDate, DateTimeImmutable $endDate): self
    {
        if ($endDate < $startDate) {
            throw new InvalidArgumentException('The endDate of a relevancy interval must not be before its startDate.');
        }

        return new self([
            'startDate' => $startDate->format(DateTimeInterface::W3C),
            'endDate' => $endDate->format(DateTimeInterface::W3C),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
