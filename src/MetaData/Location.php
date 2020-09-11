<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

class Location
{
    private float $latitude;
    private float $longitude;
    private float $altitude;
    private string $relevantText;

    public function __construct(float $latitude, float $longitude, ?float $altitude = null, ?string $relevantText = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        if ($altitude) {
            $this->altitude = $altitude;
        }

        if ($relevantText) {
            $this->relevantText = $relevantText;
        }
    }

    public function setAltitude(float $altitude): void
    {
        $this->altitude = $altitude;
    }

    public function setRelevantText(string $relevantText): void
    {
        $this->relevantText = $relevantText;
    }

    /**
     * @return array<string, float|string>
     */
    public function toArray(): array
    {
        $data = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if (isset($this->altitude)) {
            $data['altitude'] = $this->altitude;
        }

        if (isset($this->relevantText)) {
            $data['relevantText'] = $this->relevantText;
        }

        return $data;
    }
}
