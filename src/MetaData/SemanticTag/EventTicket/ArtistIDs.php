<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class ArtistIDs implements SemanticTag
{
    /** @var array<string> */
    private array $artistIDs = [];

    public function __construct(string $artistID = null)
    {
        if (isset($artistID)) {
            $this->addArtistId($artistID);
        }
    }

    public function addArtistId(string $artistID): void
    {
        $this->artistIDs[] = $artistID;
    }

    public function getKey(): string
    {
        return 'artistIDs';
    }

    /**
     * @return array<string>
     */
    public function getValue(): array
    {
        return $this->artistIDs;
    }
}