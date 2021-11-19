<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;

class Field
{
    private string $key;
    /** @var string|int|bool */
    private $value;
    private string $label;
    /** @var DataDetector[]|null */
    private ?array $dataDetectorTypes;
    private string $changeMessage;
    private TextAlignment $textAlignment;
    private string $attributedValue;

    /**
     * @param string|int|bool $value
     */
    public function __construct(?string $key = null, $value = null, ?string $label = null)
    {
        if ($key !== null) {
            $this->setKey($key);
        }

        if ($value !== null) {
            $this->setValue($value);
        }

        if ($label !== null) {
            $this->setLabel($label);
        }
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @param string|int|bool $value
     */
    public function setValue($value): void
    {
        if (!is_scalar($value)) {
            throw new InvalidArgumentException('Value should be a scalar type.');
        }

        $this->value = $value;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function addDataDetectorType(DataDetector $dataDetector): void
    {
        $this->dataDetectorTypes[$dataDetector->value] = $dataDetector;
    }

    public function setChangeMessage(string $changeMessage): void
    {
        $this->changeMessage = $changeMessage;
    }

    public function setTextAlignment(TextAlignment $textAlignment): void
    {
        $this->textAlignment = $textAlignment;
    }

    public function setAttributedValue(string $attributedValue): void
    {
        $this->attributedValue = $attributedValue;
    }

    /**
     * @return array<string, array<int, string>|bool|int|string>
     */
    public function getMetadata(): array
    {
        $data = [
            'key' => $this->key,
            'value'=> $this->value,
        ];

        if (isset($this->label)) {
            $data['label'] = $this->label;
        }

        if (isset($this->dataDetectorTypes)) {
            foreach ($this->dataDetectorTypes as $dataDetector) {
                $data['dataDetectorTypes'][] = (string) $dataDetector->value;
            }
        }

        if (isset($this->changeMessage)) {
            $data['changeMessage'] = $this->changeMessage;
        }

        if (isset($this->textAlignment)) {
            $data['textAlignment'] = (string) $this->textAlignment->value;
        }

        if (isset($this->attributedValue)) {
            $data['attributedValue'] = $this->attributedValue;
        }

        return $data;
    }
}
