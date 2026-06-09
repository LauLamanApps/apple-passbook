<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractStringArray;

class AlbumIDs extends AbstractStringArray
{
    public function getKey(): string
    {
        return 'albumIDs';
    }
}
