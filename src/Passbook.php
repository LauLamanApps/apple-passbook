<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\Color;
use LogicException;
use Ramsey\Uuid\UuidInterface;

abstract class Passbook
{
    protected const TYPE = null;

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
     * @var Barcode[]
     */
    private $barcodes = [];

    /**
     * @var DateTimeImmutable|null
     */
    private $relevantDate;

    /**
     * @var string|null
     */
    private $appLaunchURL;

    /**
     * @var array|null
     */
    private $associatedStoreIdentifiers;

    /**
     * @var string|null
     */
    private $userInfo;

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

    public function __construct(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    public function setOrganizationName(string $organizationName): void
    {
        $this->organizationName = $organizationName;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPassTypeIdentifier(string $passTypeIdentifier): void
    {
        $this->passTypeIdentifier = $passTypeIdentifier;
    }

    public function setTeamIdentifier(string $teamIdentifier): void
    {
        $this->teamIdentifier = $teamIdentifier;
    }

    public function setLogoText(string $logoText): void
    {
        $this->logoText = $logoText;
    }

    public function setRelevantDate(DateTimeImmutable $relevantDate): void
    {
        $this->relevantDate = $relevantDate;
    }

    public function setBarcode(Barcode $barcode): void
    {
        $this->barcodes[] = $barcode;
    }

    public function addLocation(Location $location): void
    {
        $this->locations[] = $location;
    }

    public function setMaxDistance(int $maxDistance): void
    {
        $this->maxDistance = $maxDistance;
    }

    public function setWebService($url, $authenticationToken): void
    {
        $this->webServiceURL = $url;
        $this->authenticationToken = $authenticationToken;
    }

    public function setForegroundColor(Color $foregroundColor): void
    {
        $this->foregroundColor = $foregroundColor;
    }

    public function setBackgroundColor(Color $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function setLabelColor(Color $labelColor): void
    {
        $this->labelColor = $labelColor;
    }

    public function addImage(Image $image): void
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

    public function addBackField(Field $field): void
    {
        $this->backFields[] = $field;
    }

    public function setAppLaunchURL(string $appLaunchURL): void
    {
        $this->appLaunchURL = $appLaunchURL;
    }

    public function addAssociatedStoreIdentifiers(int $associatedStoreIdentifiers): void
    {
        $this->associatedStoreIdentifiers[] = $associatedStoreIdentifiers;
    }

    public function setUserInfo(string $userInfo): void
    {
        $this->userInfo = $userInfo;
    }

    public function voided(): void
    {
        $this->voided = true;
    }

    public function hasPassTypeIdentifier(): bool
    {
        return $this->passTypeIdentifier !== null;
    }

    public function hasTeamIdentifier(): bool
    {
        return $this->teamIdentifier !== null;
    }

    public function getData(): array
    {
        $this->validate();

        $data = $this->getGenericData();
        $data[static::TYPE] = $this->getFieldsData();

        return $data;
    }

    private function getGenericData(): array
    {
        $data = [
            'formatVersion' => $this->formatVersion,
            'passTypeIdentifier' => $this->passTypeIdentifier,
            'serialNumber' => $this->serialNumber,
            'teamIdentifier' => $this->teamIdentifier,
            'organizationName' => $this->organizationName,
            'description' => $this->description,
        ];

        if ($this->logoText !== null) {
            $data['logoText'] = $this->logoText;
        }

        if (count($this->barcodes) > 0) {
            $data['barcode'] = $this->barcodes[0]->toArray();

            foreach ($this->barcodes as $barcode) {
                $data['barcodes'][] = $barcode->toArray();
            }
        }

        if ($this->relevantDate !== null) {
            $data['relevantDate'] = $this->relevantDate->format(DateTimeInterface::W3C);
        }

        if ($this->expirationDate !== null) {
            $data['expirationDate'] = $this->expirationDate->format(DateTimeInterface::W3C);
        }

        if ($this->appLaunchURL !== null) {
            $data['appLaunchURL'] = $this->appLaunchURL;
        }

        if ($this->associatedStoreIdentifiers !== null) {
            $data['associatedStoreIdentifiers'] = $this->associatedStoreIdentifiers;
        }

        if ($this->userInfo !== null) {
            $data['userInfo'] = $this->userInfo;
        }

        if ($this->voided === true) {
            $data['voided'] = true;
        }

        if ($this->locations !== null) {
            foreach ($this->locations as $location) {
                $data['locations'][] = $location->toArray();
            }
        }

        if ($this->maxDistance !== null) {
            $data['maxDistance'] = $this->maxDistance;
        }

        if ($this->webServiceURL && $this->authenticationToken) {
            $data['webServiceURL'] = $this->webServiceURL;
            $data['authenticationToken'] = $this->authenticationToken;
        }

        if ($this->foregroundColor !== null) {
            $data['foregroundColor'] = $this->foregroundColor->toString();
        }

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor->toString();
        }

        if ($this->labelColor !== null) {
            $data['labelColor'] = $this->labelColor->toString();
        }

        return $data;
    }

    private function getFieldsData(): array
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
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @throws LogicException
     * @throws MissingRequiredDataException
     */
    public function validate(): void
    {
        if (static::TYPE === null) {
            throw new LogicException('Please implement protected const TYPE in class.');
        }

        if ($this->passTypeIdentifier === null) {
            throw new MissingRequiredDataException('Please specify the PassTypeIdentifier before requesting the manifest data.');
        }

        if ($this->teamIdentifier === null) {
            throw new MissingRequiredDataException('Please specify the TeamIdentifier before requesting the manifest data.');
        }

        if ($this->organizationName === null) {
            throw new MissingRequiredDataException('Please specify the OrganizationName before requesting the manifest data.');
        }

        if ($this->description === null) {
            throw new MissingRequiredDataException('Please specify the Description before requesting the manifest data.');
        }
    }
}
