<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\NumberStyle;
use LogicException;

class NumberField extends Field
{
    private string $currencyCode;
    private NumberStyle $numberStyle;

    public function __construct(?string $key = null, $value = null, ?string $label = null)
    {
        parent::__construct($key, null, $label);

        if ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * @param string|int|bool $value
     */
    public function setValue($value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Value should be numeric.');
        }

        parent::setValue($value);
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        if (isset($this->numberStyle)) {
            throw new LogicException('You can not set both a \'currencyCode\' and a \'numberStyle\'. Please set only one of the 2.');
        }

        $this->currencyCode = $currencyCode;
    }

    public function setNumberStyle(NumberStyle $numberStyle): void
    {
        if (isset($this->currencyCode)) {
            throw new LogicException('You can not set both a \'currencyCode\' and a \'numberStyle\'. Please set only one of the 2.');
        }

        $this->numberStyle = $numberStyle;
    }

    /**
     * @return array<string, array<int|string, mixed>|bool|int|string>
     */
    public function getMetadata(): array
    {
        $data = parent::getMetadata();
        if (isset($this->currencyCode)) {
            $data['currencyCode'] = $this->currencyCode;
        }

        if (isset($this->numberStyle)) {
            $data['numberStyle'] = (string) $this->numberStyle->getValue();
        }

        return $data;
    }
}
