<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractString implements SemanticTag
{
    private string $value;

    public function __construct(
        string $value
    ) {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}