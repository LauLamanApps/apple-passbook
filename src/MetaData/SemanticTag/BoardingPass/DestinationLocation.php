<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractLocation;

class DestinationLocation extends AbstractLocation
{
    public function getKey(): string
    {
        return 'destinationLocation';
    }
}
