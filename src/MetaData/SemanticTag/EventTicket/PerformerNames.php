<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class PerformerNames implements SemanticTag
{
    /** @var array<string> */
    private array $performerNames = [];

    public function __construct(string $performerName = null)
    {
        if (isset($performerName)) {
            $this->addPerformer($performerName);
        }
    }

    public function addPerformer(string $name): void
    {
        $this->performerNames[] = $name;
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