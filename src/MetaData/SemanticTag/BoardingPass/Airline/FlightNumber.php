<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractInteger;

class FlightNumber extends AbstractInteger
{
    public function getKey(): string
    {
        return 'flightNumber';
    }
}
