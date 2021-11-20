<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class DepartureAirportCode extends AbstractString
{
    public function getKey(): string
    {
        return 'departureAirportCode';
    }
}
