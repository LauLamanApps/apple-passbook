<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractLocation;

class DepartureLocation extends AbstractLocation
{
    public function getKey(): string
    {
        return 'departureLocation';
    }
}
