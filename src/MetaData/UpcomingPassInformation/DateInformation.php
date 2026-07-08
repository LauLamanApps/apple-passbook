<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation;

use DateTimeImmutable;
use DateTimeInterface;

class DateInformation
{
    private bool $ignoreTimeComponents = false;
    private bool $isAllDay = false;
    private bool $isUnannounced = false;
    private bool $isUndetermined = false;
    private ?string $timeZone = null;

    public function __construct(private readonly ?DateTimeImmutable $date = null)
    {
    }

    public function ignoreTimeComponents(): void
    {
        $this->ignoreTimeComponents = true;
    }

    public function isAllDay(): void
    {
        $this->isAllDay = true;
    }

    public function isUnannounced(): void
    {
        $this->isUnannounced = true;
    }

    public function isUndetermined(): void
    {
        $this->isUndetermined = true;
    }

    public function setTimeZone(string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }

    /**
     * @return array<string, bool|string>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->date !== null) {
            $data['date'] = $this->date->format(DateTimeInterface::W3C);
        }

        if ($this->ignoreTimeComponents) {
            $data['ignoreTimeComponents'] = true;
        }

        if ($this->isAllDay) {
            $data['isAllDay'] = true;
        }

        if ($this->isUnannounced) {
            $data['isUnannounced'] = true;
        }

        if ($this->isUndetermined) {
            $data['isUndetermined'] = true;
        }

        if ($this->timeZone !== null) {
            $data['timeZone'] = $this->timeZone;
        }

        return $data;
    }
}
