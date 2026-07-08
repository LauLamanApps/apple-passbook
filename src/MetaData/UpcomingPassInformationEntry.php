<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\DateInformation;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\EntryImages;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\Urls;

class UpcomingPassInformationEntry
{
    public const TYPE_EVENT = 'event';

    /** @var Field[] */
    private array $additionalInfoFields = [];
    /** @var int[] */
    private array $auxiliaryStoreIdentifiers = [];
    /** @var Field[] */
    private array $backFields = [];
    private ?DateInformation $dateInformation = null;
    private ?EntryImages $images = null;
    private bool $isActive = false;
    /** @var SemanticTag[] */
    private array $semantics = [];
    private ?Urls $urls = null;

    public function __construct(
        private readonly string $identifier,
        private readonly string $name,
        private readonly string $type = self::TYPE_EVENT,
    ) {
    }

    public function addAdditionalInfoField(Field $field): void
    {
        $this->additionalInfoFields[] = $field;
    }

    public function addAuxiliaryStoreIdentifier(int $auxiliaryStoreIdentifier): void
    {
        $this->auxiliaryStoreIdentifiers[] = $auxiliaryStoreIdentifier;
    }

    public function addBackField(Field $field): void
    {
        $this->backFields[] = $field;
    }

    public function setDateInformation(DateInformation $dateInformation): void
    {
        $this->dateInformation = $dateInformation;
    }

    public function setImages(EntryImages $images): void
    {
        $this->images = $images;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function addSemanticTag(SemanticTag $semanticTag): void
    {
        $this->semantics[] = $semanticTag;
    }

    public function setUrls(Urls $urls): void
    {
        $this->urls = $urls;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'identifier' => $this->identifier,
            'name' => $this->name,
            'type' => $this->type,
        ];

        foreach ($this->additionalInfoFields as $field) {
            $data['additionalInfoFields'][] = $field->getMetadata();
        }

        if (count($this->auxiliaryStoreIdentifiers) > 0) {
            $data['auxiliaryStoreIdentifiers'] = $this->auxiliaryStoreIdentifiers;
        }

        foreach ($this->backFields as $field) {
            $data['backFields'][] = $field->getMetadata();
        }

        if ($this->dateInformation !== null) {
            $data['dateInformation'] = $this->dateInformation->toArray();
        }

        if ($this->images !== null) {
            $data['images'] = $this->images->toArray();
        }

        if ($this->isActive) {
            $data['isActive'] = true;
        }

        foreach ($this->semantics as $tag) {
            $data['semantics'][$tag->getKey()] = $tag->getValue();
        }

        if ($this->urls !== null) {
            $data['URLs'] = $this->urls->toArray();
        }

        return $data;
    }
}
