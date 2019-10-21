<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

final class Location
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

    public function __construct(float $latitude, float $longitude, ?string $relevantText = null, ?float $altitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->relevantText = $relevantText;
        $this->altitude = $altitude;
    }

    public function toArray(): array
    {
        $data = [
            'latitude' => $this->latitude,
            'longitude' => $this->latitude,
        ];

        if ($this->altitude) {
            $data['altitude'] = $this->altitude;
        }

        if ($this->relevantText) {
            $data['relevantText'] = $this->relevantText;
        }

        return $data;
    }
}
