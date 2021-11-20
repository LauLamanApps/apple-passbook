<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class ArtistIDs implements SemanticTag
{
    private array $artistIDs = [];

    public function addArtistId(string $artistID): void
    {
        $this->artistIDs[] = $artistID;
    }

    public function getKey(): string
    {
        return 'artistIDs';
    }

    public function getValue(): array
    {
        return $this->artistIDs;
    }
}