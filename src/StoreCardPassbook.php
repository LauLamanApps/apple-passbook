<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

final class StoreCardPassbook extends Passbook
{
    public function getData(): array
    {
        $data = [
            'storeCard' => $this->getFieldsData(),
        ];

        return array_merge($data, $this->getGenericData());
    }
}
