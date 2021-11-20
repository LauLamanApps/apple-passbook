<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

abstract class AbstractCurrencyAmount implements SemanticTag
{
    private string $amount;
    private string $currencyCode;

    public function __construct(
        string $amount,
        string $currencyCode
    ) {
        $this->amount = $amount;
        $this->currencyCode = $currencyCode;
    }

    public function getKey(): string
    {
        return 'totalPrice';
    }

    /**
     * @return array<string, string>
     */
    public function getValue(): array
    {
        return [
            'amount' => $this->amount,
            'currencyCode' => $this->currencyCode,
        ];
    }
}