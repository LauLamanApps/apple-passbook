<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class TransitProvider extends AbstractString
{
    public function getKey(): string
    {
        return 'transitProvider';
    }
}
