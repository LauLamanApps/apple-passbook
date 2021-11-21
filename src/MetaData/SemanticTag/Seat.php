<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class Seat
{
    private ?string $description;
    private ?string $identifier;
    private ?string $number;
    private ?string $row;
    private ?string $section;
    private ?string $type;

    public function __construct(
        ?string $description = null,
        ?string $identifier = null,
        ?string $number = null,
        ?string $row = null,
        ?string $section = null,
        ?string $type = null
    ) {
        $this->description = $description;
        $this->identifier = $identifier;
        $this->number = $number;
        $this->row = $row;
        $this->section = $section;
        $this->type = $type;
    }

    /**
     * @return array<string, string>
     */
    public function getValue(): array
    {
        $data = [];

        if (isset($this->description)) {
            $data['seatDescription'] = $this->description;
        }

        if (isset($this->identifier)) {
            $data['seatIdentifier'] = $this->identifier;
        }

        if (isset($this->number)) {
            $data['seatNumber'] = $this->number;
        }

        if (isset($this->row)) {
            $data['seatRow'] = $this->row;
        }

        if (isset($this->section)) {
            $data['seatSection'] = $this->section;
        }

        if (isset($this->type)) {
            $data['seatType'] = $this->type;
        }

        return $data;
    }
}