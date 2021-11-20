<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class Seats implements SemanticTag
{
    /** @var Seat[]  */
    private array $seats = [];

    public function addSeat(Seat $seat): void
    {
        $this->seats[] = $seat;
    }

    public function getKey(): string
    {
        return 'seats';
    }
    /**
     * @return array<array<string, string>>
     */
    public function getValue(): array
    {
        $seats = [];

        foreach ($this->seats as $seat) {
            $seats[] = $seat->getValue();
        }

        return $seats;
    }
}