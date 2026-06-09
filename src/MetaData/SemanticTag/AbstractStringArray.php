<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractStringArray implements SemanticTag
{
    /** @var array<string> */
    private array $values = [];

    public function __construct(?string $value = null)
    {
        if ($value !== null) {
            $this->add($value);
        }
    }

    public function add(string $value): void
    {
        $this->values[] = $value;
    }

    /**
     * @return array<string>
     */
    public function getValue(): array
    {
        return $this->values;
    }
}
