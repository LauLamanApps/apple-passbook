<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Field;

use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use LogicException;

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

    public function __construct(string $key, $value, ?string $label = null)
    {
        if (!is_scalar($value)) {
            throw new LogicException('Value should be a scalar type.');
        }

        $this->key = $key;
        $this->value = $value;
        $this->label = $label;
    }

    public function setDataDetectorTypes(DataDetector $dataDetectorTypes): void
    {
        $this->dataDetectorTypes = $dataDetectorTypes;
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
            $data['dataDetectorTypes'] = [$this->dataDetectorTypes->getValue()];
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
