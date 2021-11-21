<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractDate implements SemanticTag
{
    private DateTimeImmutable $value;

    public function __construct(
        DateTimeImmutable $value
    ) {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value->format(DateTimeInterface::ISO8601);
    }
}
