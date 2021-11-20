<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractLocation;

class VenueLocation extends AbstractLocation
{
    public function getKey(): string
    {
        return 'venueLocation';
    }
}
