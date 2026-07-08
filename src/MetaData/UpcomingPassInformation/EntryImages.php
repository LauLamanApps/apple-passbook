<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation;

class EntryImages
{
    private ?EntryImage $headerImage = null;
    private ?EntryImage $venueMap = null;

    public function setHeaderImage(EntryImage $headerImage): void
    {
        $this->headerImage = $headerImage;
    }

    public function setVenueMap(EntryImage $venueMap): void
    {
        $this->venueMap = $venueMap;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->headerImage !== null) {
            $data['headerImage'] = $this->headerImage->toArray();
        }

        if ($this->venueMap !== null) {
            $data['venueMap'] = $this->venueMap->toArray();
        }

        return $data;
    }
}
