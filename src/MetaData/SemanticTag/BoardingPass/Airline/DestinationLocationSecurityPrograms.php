<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractStringArray;

class DestinationLocationSecurityPrograms extends AbstractStringArray
{
    public function getKey(): string
    {
        return 'destinationLocationSecurityPrograms';
    }
}
