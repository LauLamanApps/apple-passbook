<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;

class BoardingPassbook extends Passbook
{
    protected const TYPE = 'boardingPass';

    private TransitType $transitType;

    public function __construct(string $serialNumber, TransitType $transitType = null)
    {
        parent::__construct($serialNumber);

        if ($transitType) {
            $this->setTransitType($transitType);
        }
    }


    public function setTransitType(TransitType $transitType): void
    {
        $this->transitType = $transitType;
    }

    /**
     * @throws MissingRequiredDataException
     */
    public function validate(): void
    {
        parent::validate();

        if (!isset($this->transitType)) {
            throw new MissingRequiredDataException('Please specify the TransitType before requesting the manifest data.');
        }
    }

    /**
     * @return array<int|string,array<string, array<array<array<int, string>|bool|int|string>|string>|string>|string>
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data[static::TYPE]['transitType'] = (string) $this->transitType->getValue();

        return $data;
    }
}
