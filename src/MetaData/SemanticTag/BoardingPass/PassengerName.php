<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class PassengerName implements SemanticTag
{
    private string $familyName;
    private string $givenName;
    private string $middleName;
    private string $namePrefix;
    private string $nameSuffix;
    private string $nickname;
    private string $phoneticRepresentation;

    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function setNamePrefix(string $namePrefix): void
    {
        $this->namePrefix = $namePrefix;
    }

    public function setNameSuffix(string $nameSuffix): void
    {
        $this->nameSuffix = $nameSuffix;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function setPhoneticRepresentation(string $phoneticRepresentation): void
    {
        $this->phoneticRepresentation = $phoneticRepresentation;
    }

    public function getKey(): string
    {
        return 'passengerName';
    }

    public function getValue(): array
    {
        $data = [];

        if (isset($this->familyName)) {
            $data['familyName'] = $this->familyName;
        }

        if (isset($this->givenName)) {
            $data['givenName'] = $this->givenName;
        }

        if (isset($this->middleName)) {
            $data['middleName'] = $this->middleName;
        }

        if (isset($this->namePrefix)) {
            $data['namePrefix'] = $this->namePrefix;
        }

        if (isset($this->nameSuffix)) {
            $data['nameSuffix'] = $this->nameSuffix;
        }

        if (isset($this->nickname)) {
            $data['nickname'] = $this->nickname;
        }

        if (isset($this->phoneticRepresentation)) {
            $data['phoneticRepresentation'] = $this->phoneticRepresentation;
        }

        return $data;
    }
}
