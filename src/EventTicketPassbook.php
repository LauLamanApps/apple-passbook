<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

class EventTicketPassbook extends Passbook
{
    protected const TYPE = 'eventTicket';

    private string $accessibilityURL;
    private string $addOnURL;
    private string $bagPolicyURL;
    private string $contactVenueEmail;
    private string $contactVenuePhoneNumber;
    private string $contactVenueWebsite;
    private string $directionsInformationURL;
    private string $merchandiseURL;
    private string $orderFoodURL;
    private string $parkingInformationURL;
    private string $purchaseParkingURL;
    private string $sellURL;
    private string $transferURL;
    private string $transitInformationURL;

    public function setAccessibilityURL(string $url): void
    {
        $this->accessibilityURL = $url;
    }

    public function setAddOnURL(string $url): void
    {
        $this->addOnURL = $url;
    }

    public function setBagPolicyURL(string $url): void
    {
        $this->bagPolicyURL = $url;
    }

    public function setContactVenueEmail(string $email): void
    {
        $this->contactVenueEmail = $email;
    }

    public function setContactVenuePhoneNumber(string $phoneNumber): void
    {
        $this->contactVenuePhoneNumber = $phoneNumber;
    }

    public function setContactVenueWebsite(string $url): void
    {
        $this->contactVenueWebsite = $url;
    }

    public function setDirectionsInformationURL(string $url): void
    {
        $this->directionsInformationURL = $url;
    }

    public function setMerchandiseURL(string $url): void
    {
        $this->merchandiseURL = $url;
    }

    public function setOrderFoodURL(string $url): void
    {
        $this->orderFoodURL = $url;
    }

    public function setParkingInformationURL(string $url): void
    {
        $this->parkingInformationURL = $url;
    }

    public function setPurchaseParkingURL(string $url): void
    {
        $this->purchaseParkingURL = $url;
    }

    public function setSellURL(string $url): void
    {
        $this->sellURL = $url;
    }

    public function setTransferURL(string $url): void
    {
        $this->transferURL = $url;
    }

    public function setTransitInformationURL(string $url): void
    {
        $this->transitInformationURL = $url;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getData(): array
    {
        $data = parent::getData();

        if (isset($this->accessibilityURL)) {
            $data['accessibilityURL'] = $this->accessibilityURL;
        }
        if (isset($this->addOnURL)) {
            $data['addOnURL'] = $this->addOnURL;
        }
        if (isset($this->bagPolicyURL)) {
            $data['bagPolicyURL'] = $this->bagPolicyURL;
        }
        if (isset($this->contactVenueEmail)) {
            $data['contactVenueEmail'] = $this->contactVenueEmail;
        }
        if (isset($this->contactVenuePhoneNumber)) {
            $data['contactVenuePhoneNumber'] = $this->contactVenuePhoneNumber;
        }
        if (isset($this->contactVenueWebsite)) {
            $data['contactVenueWebsite'] = $this->contactVenueWebsite;
        }
        if (isset($this->directionsInformationURL)) {
            $data['directionsInformationURL'] = $this->directionsInformationURL;
        }
        if (isset($this->merchandiseURL)) {
            $data['merchandiseURL'] = $this->merchandiseURL;
        }
        if (isset($this->orderFoodURL)) {
            $data['orderFoodURL'] = $this->orderFoodURL;
        }
        if (isset($this->parkingInformationURL)) {
            $data['parkingInformationURL'] = $this->parkingInformationURL;
        }
        if (isset($this->purchaseParkingURL)) {
            $data['purchaseParkingURL'] = $this->purchaseParkingURL;
        }
        if (isset($this->sellURL)) {
            $data['sellURL'] = $this->sellURL;
        }
        if (isset($this->transferURL)) {
            $data['transferURL'] = $this->transferURL;
        }
        if (isset($this->transitInformationURL)) {
            $data['transitInformationURL'] = $this->transitInformationURL;
        }

        return $data;
    }
}
