<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;
use LauLamanApps\ApplePassbook\Style\Color;
use LogicException;

abstract class Passbook
{
    protected const TYPE = null;

    private int $formatVersion = 1;
    private string $passTypeIdentifier;
    private string $serialNumber;
    private string $teamIdentifier;
    private string $organizationName;
    private string $description;
    private string $logoText;
    /** @var Barcode[] */
    private array $barcodes = [];
    private DateTimeImmutable $relevantDate;
    private string $appLaunchURL;
    /** @var int[] */
    private array $associatedStoreIdentifiers = [];
    private string $userInfo;
    private DateTimeImmutable $expirationDate;
    private bool $voided;
    /** @var Location[] */
    private array $locations = [];
    private int $maxDistance;
    private string $webServiceURL;
    private string $authenticationToken;
    private Color $foregroundColor;
    private Color $backgroundColor;
    private Color $labelColor;
    /** @var Image[] */
    private array $images = [];
    /** @var Field[] */
    private array $headerFields = [];
    /** @var Field[] */
    private array $primaryFields = [];
    /** @var Field[] */
    private array $auxiliaryFields = [];
    /** @var Field[] */
    private array $secondaryFields = [];
    /** @var Field[] */
    private array $backFields = [];

    /** @var SemanticTag[] */
    private array $semantics;

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

    public function setExpirationDate(DateTimeImmutable $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
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

    public function setWebService(string $url, string $authenticationToken): void
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

    public function addSemanticTag(SemanticTag $semanticTag): void
    {
        $this->semantics[] = $semanticTag;
    }

    public function setUserInfo(string $userInfo): void
    {
        $this->userInfo = $userInfo;
    }

    public function voided(): void
    {
        $this->voided = true;
    }

    public function isVoided(): bool
    {
        return isset($this->voided);
    }

    public function hasPassTypeIdentifier(): bool
    {
        return isset($this->passTypeIdentifier);
    }

    public function hasTeamIdentifier(): bool
    {
        return isset($this->teamIdentifier);
    }

    /**
     * @return array<int|string, mixed>
     * @throws MissingRequiredDataException
     */
    public function getData(): array
    {
        $this->validate();

        $data = $this->getGenericData();
        $data[static::TYPE] = $this->getFieldsData();

        return $data;
    }

    /**
     * @return array<int|string, mixed>
     */
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

        if (isset($this->logoText)) {
            $data['logoText'] = $this->logoText;
        }

        if (count($this->barcodes) > 0) {
            $data['barcode'] = $this->barcodes[0]->toArray();

            foreach ($this->barcodes as $barcode) {
                $data['barcodes'][] = $barcode->toArray();
            }
        }

        if (isset($this->relevantDate)) {
            $data['relevantDate'] = $this->relevantDate->format(DateTimeInterface::W3C);
        }

        if (isset($this->expirationDate)) {
            $data['expirationDate'] = $this->expirationDate->format(DateTimeInterface::W3C);
        }

        if (isset($this->appLaunchURL)) {
            $data['appLaunchURL'] = $this->appLaunchURL;
        }

        if (count($this->associatedStoreIdentifiers) > 0) {
            $data['associatedStoreIdentifiers'] = $this->associatedStoreIdentifiers;
        }

        if (isset($this->userInfo)) {
            $data['userInfo'] = $this->userInfo;
        }

        if (isset($this->voided)) {
            $data['voided'] = $this->voided;
        }

        if (isset($this->locations)) {
            foreach ($this->locations as $location) {
                $data['locations'][] = $location->toArray();
            }
        }

        if (isset($this->maxDistance)) {
            $data['maxDistance'] = $this->maxDistance;
        }

        if (isset($this->webServiceURL) && isset($this->authenticationToken)) {
            $data['webServiceURL'] = $this->webServiceURL;
            $data['authenticationToken'] = $this->authenticationToken;
        }

        if (isset($this->foregroundColor)) {
            $data['foregroundColor'] = $this->foregroundColor->toString();
        }

        if (isset($this->backgroundColor)) {
            $data['backgroundColor'] = $this->backgroundColor->toString();
        }

        if (isset($this->labelColor)) {
            $data['labelColor'] = $this->labelColor->toString();
        }

        if (isset($this->semantics)) {
            foreach ($this->semantics as $tag) {
                $data['semantics'][$tag->getKey()] = $tag->getValue();
            }
        }

        return $data;
    }

    /**
     * @return array<int|string, mixed>
     */
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

        if (!isset($this->passTypeIdentifier)) {
            throw new MissingRequiredDataException('Please specify the PassTypeIdentifier before requesting the manifest data.');
        }

        if (!isset($this->teamIdentifier)) {
            throw new MissingRequiredDataException('Please specify the TeamIdentifier before requesting the manifest data.');
        }

        if (!isset($this->organizationName)) {
            throw new MissingRequiredDataException('Please specify the OrganizationName before requesting the manifest data.');
        }

        if (!isset($this->description)) {
            throw new MissingRequiredDataException('Please specify the Description before requesting the manifest data.');
        }
    }
}
