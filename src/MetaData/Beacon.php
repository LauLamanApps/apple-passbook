<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use Ramsey\Uuid\UuidInterface;

class Beacon
{
    private int $minorIdentifier;
    private int $majorIdentifier;
    private UuidInterface $proximityUUID;
    private string $relevantText;

    public function __construct(UuidInterface $proximityUUID)
    {
        $this->proximityUUID = $proximityUUID;
    }

    public function setMinorIdentifier(int $minorIdentifier): void
    {
        $this->minorIdentifier = $minorIdentifier;
    }

    public function setMajorIdentifier(int $majorIdentifier): void
    {
        $this->majorIdentifier = $majorIdentifier;
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
            'proximityUUID' => $this->proximityUUID->toString(),
        ];

        if (isset($this->minorIdentifier)) {
            $data['minor'] = $this->minorIdentifier;
        }

        if (isset($this->majorIdentifier)) {
            $data['major'] = $this->majorIdentifier;
        }

        if (isset($this->relevantText)) {
            $data['relevantText'] = $this->relevantText;
        }

        return $data;
    }
}
