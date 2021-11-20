<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\Sport;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractString;

class HomeTeamLocation extends AbstractString
{
    public function getKey(): string
    {
        return 'homeTeamLocation';
    }
}
