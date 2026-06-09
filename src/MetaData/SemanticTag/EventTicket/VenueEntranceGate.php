<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class VenueEntranceGate extends AbstractString
{
    public function getKey(): string
    {
        return 'venueEntranceGate';
    }
}
