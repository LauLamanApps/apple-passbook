<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class DestinationLocationDescription extends AbstractString
{
    public function getKey(): string
    {
        return 'destinationLocationDescription';
    }
}
