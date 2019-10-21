<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

final class GenericPassbook extends Passbook
{
    public function getData(): array
    {
        $data = [
            'generic' => $this->getFieldsData(),
        ];

        return array_merge($data, $this->getGenericData());
    }
}
