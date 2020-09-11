<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\DateStyle;

class DateField extends Field
{
    private DateStyle $dateStyle;
    private DateStyle $timeStyle;
    private bool $ignoresTimeZone = false;
    private bool $isRelative = false;

    public function __construct(?string $key = null, ?DateTimeImmutable $date = null, ?string $label = null)
    {
        parent::__construct($key, null, $label);

        if ($date !== null) {
            $this->setDate($date);
        }
    }

    public function setDate(DateTimeImmutable $date): void
    {
        parent::setValue($date->format(DateTimeImmutable::W3C));
    }

    public function setDateStyle(DateStyle $dateStyle): void
    {
        $this->dateStyle = $dateStyle;
    }

    public function setTimeStyle(DateStyle $timeStyle): void
    {
        $this->timeStyle = $timeStyle;
    }

    public function ignoresTimeZone(): void
    {
        $this->ignoresTimeZone = true;
    }

    public function isRelative(): void
    {
        $this->isRelative = true;
    }

    /**
     * @return array<string>
     */
    public function getMetadata(): array
    {
        $data = parent::getMetadata();

        if (isset($this->dateStyle)) {
            $data['dateStyle'] = $this->dateStyle->getValue();
        }

        if (isset($this->timeStyle)) {
            $data['timeStyle'] = $this->timeStyle->getValue();
        }

        if ($this->ignoresTimeZone) {
            $data['ignoresTimeZone'] = $this->ignoresTimeZone;
        }

        if ($this->isRelative) {
            $data['isRelative'] = $this->isRelative;
        }

        return $data;
    }
}
