<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class Duration extends AbstractInteger
{
    public function getKey(): string
    {
        return 'duration';
    }
}
