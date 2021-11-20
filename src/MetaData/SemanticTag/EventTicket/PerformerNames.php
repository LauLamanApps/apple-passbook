<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class PerformerNames implements SemanticTag
{
    /** @var array<string> */
    private array $performerNames = [];

    public function addPerformerName(string $performerName): void
    {
        $this->performerNames[] = $performerName;
    }

    public function getKey(): string
    {
        return 'performerNames';
    }

    /**
     * @return array<string>
     */
    public function getValue(): array
    {
        return $this->performerNames;
    }
}