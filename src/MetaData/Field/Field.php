<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;

class Field
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string|int|bool
     */
    private $value;

    /**
     * @var string|null
     */
    private $label;

    /**
     * @var DataDetector[]|null
     */
    private $dataDetectorTypes;

    /**
     * @var string|null
     */
    private $changeMessage;

    /**
     * @var TextAlignment|null
     */
    private $textAlignment;

    /**
     * @var string|null
     */
    private $attributedValue;

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
        $this->dataDetectorTypes[$dataDetector->getValue()] = $dataDetector;
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

    public function getMetadata(): array
    {
        $data = [
            'key' => $this->key,
            'value'=> $this->value,
        ];

        if ($this->label) {
            $data['label'] = $this->label;
        }

        if ($this->dataDetectorTypes) {
            foreach ($this->dataDetectorTypes as $dataDetector) {
                $data['dataDetectorTypes'][] = $dataDetector->getValue();
            }
        }

        if ($this->changeMessage) {
            $data['changeMessage'] = $this->changeMessage;
        }

        if ($this->textAlignment) {
            $data['textAlignment'] = $this->textAlignment->getValue();
        }

        if ($this->attributedValue) {
            $data['attributedValue'] = $this->attributedValue;
        }

        return $data;
    }
}
