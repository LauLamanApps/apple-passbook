<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\Style\DateStyle;

class DateField extends Field
{
    /**
     * @var DateStyle|null
     */
    private $dateStyle;

    /**
     * @var DateStyle|null;
     */
    private $timeStyle;

    /**
     * @var bool
     */
    private $ignoresTimeZone = false;

    /**
     * @var bool
     */
    private $isRelative = false;

    public function __construct(string $key, DateTimeImmutable $date, ?string $label = null)
    {
        parent::__construct($key, $date->format(DateTimeImmutable::W3C), $label);
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

    public function getMetadata(): array
    {
        $data = parent::getMetadata();

        if ($this->dateStyle) {
            $data['dateStyle'] = $this->dateStyle->getValue();
        }

        if ($this->timeStyle) {
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
