<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

class Location
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $altitude;

    /**
     * @var string
     */
    private $relevantText;

    public function __construct(float $latitude, float $longitude, ?float $altitude = null, ?string $relevantText = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
        $this->relevantText = $relevantText;
    }

    public function setAltitude(float $altitude): void
    {
        $this->altitude = $altitude;
    }

    public function setRelevantText(string $relevantText): void
    {
        $this->relevantText = $relevantText;
    }

    public function toArray(): array
    {
        $data = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if ($this->altitude !== null) {
            $data['altitude'] = $this->altitude;
        }

        if ($this->relevantText) {
            $data['relevantText'] = $this->relevantText;
        }

        return $data;
    }
}
