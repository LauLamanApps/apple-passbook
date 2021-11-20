<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class EventType implements SemanticTag
{
    private EventTypeEnum $eventType;

    public function __construct(
        EventTypeEnum $eventType
    ) {
        $this->eventType = $eventType;
    }

    public function getKey(): string
    {
        return 'eventType';
    }

    public function getValue(): string
    {
        return $this->eventType->getValue();
    }
}
