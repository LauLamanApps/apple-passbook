<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

interface SemanticTag
{
    public function getKey(): string;
    public function getValue();
}