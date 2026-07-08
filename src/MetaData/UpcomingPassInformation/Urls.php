<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation;

class Urls
{
    private ?string $accessibilityURL = null;
    private ?string $addOnURL = null;
    private ?string $bagPolicyURL = null;
    private ?string $contactVenueEmail = null;
    private ?string $contactVenuePhoneNumber = null;
    private ?string $contactVenueWebsite = null;
    private ?string $directionsInformationURL = null;
    private ?string $merchandiseURL = null;
    private ?string $orderFoodURL = null;
    private ?string $parkingInformationURL = null;
    private ?string $purchaseParkingURL = null;
    private ?string $sellURL = null;
    private ?string $transferURL = null;
    private ?string $transitInformationURL = null;

    public function setAccessibilityURL(string $accessibilityURL): void
    {
        $this->accessibilityURL = $accessibilityURL;
    }

    public function setAddOnURL(string $addOnURL): void
    {
        $this->addOnURL = $addOnURL;
    }

    public function setBagPolicyURL(string $bagPolicyURL): void
    {
        $this->bagPolicyURL = $bagPolicyURL;
    }

    public function setContactVenueEmail(string $contactVenueEmail): void
    {
        $this->contactVenueEmail = $contactVenueEmail;
    }

    public function setContactVenuePhoneNumber(string $contactVenuePhoneNumber): void
    {
        $this->contactVenuePhoneNumber = $contactVenuePhoneNumber;
    }

    public function setContactVenueWebsite(string $contactVenueWebsite): void
    {
        $this->contactVenueWebsite = $contactVenueWebsite;
    }

    public function setDirectionsInformationURL(string $directionsInformationURL): void
    {
        $this->directionsInformationURL = $directionsInformationURL;
    }

    public function setMerchandiseURL(string $merchandiseURL): void
    {
        $this->merchandiseURL = $merchandiseURL;
    }

    public function setOrderFoodURL(string $orderFoodURL): void
    {
        $this->orderFoodURL = $orderFoodURL;
    }

    public function setParkingInformationURL(string $parkingInformationURL): void
    {
        $this->parkingInformationURL = $parkingInformationURL;
    }

    public function setPurchaseParkingURL(string $purchaseParkingURL): void
    {
        $this->purchaseParkingURL = $purchaseParkingURL;
    }

    public function setSellURL(string $sellURL): void
    {
        $this->sellURL = $sellURL;
    }

    public function setTransferURL(string $transferURL): void
    {
        $this->transferURL = $transferURL;
    }

    public function setTransitInformationURL(string $transitInformationURL): void
    {
        $this->transitInformationURL = $transitInformationURL;
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return array_filter([
            'accessibilityURL' => $this->accessibilityURL,
            'addOnURL' => $this->addOnURL,
            'bagPolicyURL' => $this->bagPolicyURL,
            'contactVenueEmail' => $this->contactVenueEmail,
            'contactVenuePhoneNumber' => $this->contactVenuePhoneNumber,
            'contactVenueWebsite' => $this->contactVenueWebsite,
            'directionsInformationURL' => $this->directionsInformationURL,
            'merchandiseURL' => $this->merchandiseURL,
            'orderFoodURL' => $this->orderFoodURL,
            'parkingInformationURL' => $this->parkingInformationURL,
            'purchaseParkingURL' => $this->purchaseParkingURL,
            'sellURL' => $this->sellURL,
            'transferURL' => $this->transferURL,
            'transitInformationURL' => $this->transitInformationURL,
        ], static fn (?string $value): bool => $value !== null);
    }
}
