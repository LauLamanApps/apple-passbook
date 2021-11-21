<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractTrue implements SemanticTag
{
    public function getValue(): bool
    {
        return true;
    }
}
