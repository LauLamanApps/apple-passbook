<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

final class EventTicketPassbook extends Passbook
{
    public function getData(): array
    {
        $data = [
            'eventTicket' => $this->getFieldsData(),
        ];

        return array_merge($data, $this->getGenericData());
    }
}
