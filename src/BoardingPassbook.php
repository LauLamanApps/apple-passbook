<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;
use Ramsey\Uuid\UuidInterface;

final class BoardingPassbook extends Passbook
{
    /**
     * @var TransitType
     */
    private $transitType;

    public function __construct(UuidInterface $serialNumber, TransitType $transitType, string $organizationName, string $description)
    {
        parent::__construct($serialNumber, $organizationName, $description);
        $this->transitType = $transitType;
    }

    public function getData(): array
    {
        $data = [
            'boardingPass' => $this->getFieldsData(),
            'transitType' => $this->transitType->getValue(),
        ];

        return array_merge($data, $this->getGenericData());
    }
}
