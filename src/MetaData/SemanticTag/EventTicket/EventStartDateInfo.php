<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class EventStartDateInfo implements SemanticTag
{
    private DateTimeImmutable $startDate;
    private ?string $timeZone = null;
    private ?string $status = null;

    public function __construct(DateTimeImmutable $startDate)
    {
        $this->startDate = $startDate;
    }

    public function setTimeZone(string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getKey(): string
    {
        return 'eventStartDateInfo';
    }

    /** @return array<string, string> */
    public function getValue(): array
    {
        $data = [
            'startDate' => $this->startDate->format(DateTimeInterface::ISO8601),
        ];
        if ($this->timeZone !== null) {
            $data['timeZone'] = $this->timeZone;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        return $data;
    }
}
