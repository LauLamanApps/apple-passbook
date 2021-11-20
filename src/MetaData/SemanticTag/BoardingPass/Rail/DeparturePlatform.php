<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Rail;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class DeparturePlatform extends AbstractString
{
    public function getKey(): string
    {
        return 'departurePlatform';
    }
}
