<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

final class CouponPassbook extends Passbook
{
    public function getData(): array
    {
        $data = [
            'coupon' => $this->getFieldsData(),
        ];

        return array_merge($data, $this->getGenericData());
    }
}
