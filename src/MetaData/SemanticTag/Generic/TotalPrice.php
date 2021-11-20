<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractCurrencyAmount;

class TotalPrice extends AbstractCurrencyAmount
{
    public function getKey(): string
    {
        return 'totalPrice';
    }
}
