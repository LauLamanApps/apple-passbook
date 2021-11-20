<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class SilenceRequested extends AbstractTrue
{
    public function getKey(): string
    {
        return 'silenceRequested';
    }
}
