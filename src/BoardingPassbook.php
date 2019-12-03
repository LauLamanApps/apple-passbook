<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;

class BoardingPassbook extends Passbook
{
    protected const TYPE = 'boardingPass';

    /**
     * @var TransitType
     */
    private $transitType;

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

        if ($this->transitType === null) {
            throw new MissingRequiredDataException('Please specify the TransitType before requesting the manifest data.');
        }
    }


    public function getData(): array
    {
        $data = parent::getData();

        return array_merge(['transitType' => $this->transitType->getValue()], $data);
    }
}
