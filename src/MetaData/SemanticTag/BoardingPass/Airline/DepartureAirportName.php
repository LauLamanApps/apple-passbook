<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class DepartureAirportName extends AbstractString
{
    public function getKey(): string
    {
        return 'departureAirportName';
    }
}
