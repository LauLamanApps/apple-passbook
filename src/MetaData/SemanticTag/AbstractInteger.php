<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractInteger implements SemanticTag
{
    private int $value;

    public function __construct(
        int $value
    ) {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
