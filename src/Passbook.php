<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\Color;
use LogicException;
use Ramsey\Uuid\UuidInterface;

abstract class Passbook
{
    /**
     * @var int
     */
    private $formatVersion = 1;

    /**
     * @var string
     */
    private $passTypeIdentifier;

    /**
     * @var string
     */
    private $serialNumber;

    /**
     * @var string
     */
    private $teamIdentifier;

    /**
     * @var string
     */
    private $organizationName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string|null
     */
    private $logoText;

    /**
     * @var Barcode[]|null
     */
    private $barcodes;

    /**
     * @var DateTimeImmutable|null
     */
    private $relevantDate;

    /**
     * @var DateTimeImmutable|null
     */
    private $expirationDate;

    /**
     * @var boolean|null
     */
    private $voided;

    /**
     * @var Location[]|null
     */
    private $locations;

    /**
     * @var int|null
     */
    private $maxDistance;

    /**
     * @var string|null
     */
    private $webServiceURL;

    /**
     * @var string|null
     */
    private $authenticationToken;

    /**
     * @var Color|null
     */
    private $foregroundColor;

    /**
     * @var Color|null
     */
    private $backgroundColor;

    /**
     * @var Color|null
     */
    private $labelColor;

    /**
     * @var LocalImage[]
     */
    private $images = [];

    /**
     * @var Field[]
     */
    private $headerFields = [];

    /**
     * @var Field[]
     */
    private $primaryFields = [];

    /**
     * @var Field[]
     */
    private $auxiliaryFields = [];

    /**
     * @var Field[]
     */
    private $secondaryFields = [];

    /**
     * @var Field[]
     */
    private $backFields = [];

    public function __construct(
        UuidInterface $serialNumber,
        string $organizationName,
        string $description
    ) {
        $this->serialNumber = $serialNumber;
        $this->organizationName = $organizationName;
        $this->description = $description;
    }

    public function voided(): void
    {
        $this->voided = true;
    }

    public function setPassTypeIdentifier(string $passTypeIdentifier): void
    {
        $this->passTypeIdentifier = $passTypeIdentifier;
    }

    public function setTeamIdentifier(string $teamIdentifier): void
    {
        $this->teamIdentifier = $teamIdentifier;
    }

    final public function setLogoText(string $logoText): void
    {
        $this->logoText = $logoText;
    }

    final public function setRelevantDate(DateTimeImmutable $relevantDate): void
    {
        $this->relevantDate = $relevantDate;
    }

    public function addBarcode(Barcode $barcode): void
    {
        $this->barcodes[] = $barcode;
    }

    final public function addLocation(Location $location): void
    {
        $this->locations[] = $location;
    }

    public function setMaxDistance(int $maxDistance): void
    {
        $this->maxDistance = $maxDistance;
    }

    final public function setWebService($url, $authenticationToken): void
    {
        $this->webServiceURL = $url;
        $this->authenticationToken = $authenticationToken;
    }

    final public function setForegroundColor($foregroundColor): void
    {
        $this->foregroundColor = $foregroundColor;
    }

    final public function setBackgroundColor($backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function addImage(LocalImage $image): void
    {
        $this->images[] = $image;
    }

    public function addHeaderField(Field $field): void
    {
        $this->headerFields[] = $field;
    }

    public function addPrimaryField(Field $field): void
    {
        $this->primaryFields[] = $field;
    }

    public function addAuxiliaryField(Field $field): void
    {
        $this->auxiliaryFields[] = $field;
    }

    public function addSecondaryField(Field $field): void
    {
        $this->secondaryFields[] = $field;
    }

    public function addBackFields(Field $field): void
    {
        $this->backFields[] = $field;
    }

    abstract public function getData(): array;

    public function hasPassTypeIdentifier(): bool
    {
        return $this->passTypeIdentifier !== null;
    }

    public function hasTeamIdentifier(): bool
    {
        return $this->teamIdentifier !== null;
    }

    final protected function getGenericData(): array
    {
        if ($this->passTypeIdentifier === null) {
            throw new LogicException('Please set the PassTypeIdentifier before requesting the manifest.');
        }

        if ($this->teamIdentifier === null) {
            throw new LogicException('Please set the TeamIdentifier before requesting the manifest.');
        }

        $data = [
            'formatVersion' => $this->formatVersion,
            'passTypeIdentifier' => $this->passTypeIdentifier,
            'serialNumber' => $this->serialNumber,
            'teamIdentifier' => $this->teamIdentifier,
            'organizationName' => $this->organizationName,
            'description' => $this->description,
        ];

        if ($this->logoText) {
            $data['logoText'] = $this->logoText;
        }

        if (count($this->barcodes) > 0) {
            $data['barcode'] = $this->barcodes[0]->toArray();

            foreach ($this->barcodes as $barcode) {
                $data['barcodes'][] = $barcode->toArray();
            }
            $data['barcodes'][0]['voided'] = true;
        }

        if ($this->relevantDate) {
            $data['relevantDate'] = $this->relevantDate->format(DateTimeInterface::W3C);
        }

        if ($this->expirationDate) {
            $data['expirationDate'] = $this->expirationDate->format(DateTimeInterface::W3C);
        }

        if ($this->voided) {
            $data['voided'] = $this->voided;
        }

        if ($this->locations) {
            foreach ($this->locations as $location) {
                $data['locations'][] = $location->toArray();
            }
        }

        if ($this->maxDistance) {
            $data['maxDistance'] = $this->maxDistance;
        }

        if ($this->webServiceURL && $this->authenticationToken) {
            $data['webServiceURL'] = $this->webServiceURL;
            $data['authenticationToken'] = $this->authenticationToken;
        }

        if ($this->foregroundColor) {
            $data['foregroundColor'] = $this->foregroundColor->toString();
        }

        if ($this->backgroundColor) {
            $data['backgroundColor'] = $this->backgroundColor->toString();
        }

        if ($this->labelColor) {
            $data['labelColor'] = $this->labelColor->toString();
        }

        return $data;
    }

    public function getFieldsData(): array
    {
        $data = [];

        foreach ($this->headerFields as $field) {
            $data['headerFields'][] = $field->getMetaData();
        }
        foreach ($this->primaryFields as $field) {
            $data['primaryFields'][] = $field->getMetaData();
        }
        foreach ($this->auxiliaryFields as $field) {
            $data['auxiliaryFields'][] = $field->getMetaData();
        }
        foreach ($this->secondaryFields as $field) {
            $data['secondaryFields'][] = $field->getMetaData();
        }
        foreach ($this->backFields as $field) {
            $data['backFields'][] = $field->getMetaData();
        }

        return $data;
    }

    /**
     * @return LocalImage[]
     */
    final public function getImages(): array
    {
        return $this->images;
    }
}
