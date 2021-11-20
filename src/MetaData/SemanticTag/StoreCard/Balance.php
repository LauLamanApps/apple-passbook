<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\StoreCard;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractCurrencyAmount;

class Balance extends AbstractCurrencyAmount
{
    public function getKey(): string
    {
        return 'balance';
    }
}
