<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractBoolean implements SemanticTag
{
    private bool $value;

    public function __construct(
        bool $value
    ) {
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
