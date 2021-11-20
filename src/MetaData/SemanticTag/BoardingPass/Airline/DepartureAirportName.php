<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class DepartureAirportName extends AbstractString
{
    public function getKey(): string
    {
        return 'departureAirportName';
    }
}
