<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractDate;

class VenueCloseDate extends AbstractDate
{
    public function getKey(): string
    {
        return 'venueCloseDate';
    }
}
