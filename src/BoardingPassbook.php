<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook;

use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;

class BoardingPassbook extends Passbook
{
    protected const TYPE = 'boardingPass';

    private TransitType $transitType;
    private string $changeSeatURL;
    private string $entertainmentURL;
    private string $managementURL;
    private string $purchaseAdditionalBaggageURL;
    private string $purchaseLoungeAccessURL;
    private string $purchaseWifiURL;
    private string $registerServiceAnimalURL;
    private string $reportLostBagURL;
    private string $requestWheelchairURL;
    private string $trackBagsURL;
    private string $transitProviderEmail;
    private string $transitProviderPhoneNumber;
    private string $transitProviderWebsiteURL;
    private string $upgradeURL;

    public function __construct(string $serialNumber, ?TransitType $transitType = null)
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

    public function setChangeSeatURL(string $url): void
    {
        $this->changeSeatURL = $url;
    }

    public function setEntertainmentURL(string $url): void
    {
        $this->entertainmentURL = $url;
    }

    public function setManagementURL(string $url): void
    {
        $this->managementURL = $url;
    }

    public function setPurchaseAdditionalBaggageURL(string $url): void
    {
        $this->purchaseAdditionalBaggageURL = $url;
    }

    public function setPurchaseLoungeAccessURL(string $url): void
    {
        $this->purchaseLoungeAccessURL = $url;
    }

    public function setPurchaseWifiURL(string $url): void
    {
        $this->purchaseWifiURL = $url;
    }

    public function setRegisterServiceAnimalURL(string $url): void
    {
        $this->registerServiceAnimalURL = $url;
    }

    public function setReportLostBagURL(string $url): void
    {
        $this->reportLostBagURL = $url;
    }

    public function setRequestWheelchairURL(string $url): void
    {
        $this->requestWheelchairURL = $url;
    }

    public function setTrackBagsURL(string $url): void
    {
        $this->trackBagsURL = $url;
    }

    public function setTransitProviderEmail(string $email): void
    {
        $this->transitProviderEmail = $email;
    }

    public function setTransitProviderPhoneNumber(string $phoneNumber): void
    {
        $this->transitProviderPhoneNumber = $phoneNumber;
    }

    public function setTransitProviderWebsiteURL(string $url): void
    {
        $this->transitProviderWebsiteURL = $url;
    }

    public function setUpgradeURL(string $url): void
    {
        $this->upgradeURL = $url;
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
     * @return array<int|string, mixed>
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data[static::TYPE]['transitType'] = $this->transitType->value;

        if (isset($this->changeSeatURL)) {
            $data['changeSeatURL'] = $this->changeSeatURL;
        }
        if (isset($this->entertainmentURL)) {
            $data['entertainmentURL'] = $this->entertainmentURL;
        }
        if (isset($this->managementURL)) {
            $data['managementURL'] = $this->managementURL;
        }
        if (isset($this->purchaseAdditionalBaggageURL)) {
            $data['purchaseAdditionalBaggageURL'] = $this->purchaseAdditionalBaggageURL;
        }
        if (isset($this->purchaseLoungeAccessURL)) {
            $data['purchaseLoungeAccessURL'] = $this->purchaseLoungeAccessURL;
        }
        if (isset($this->purchaseWifiURL)) {
            $data['purchaseWifiURL'] = $this->purchaseWifiURL;
        }
        if (isset($this->registerServiceAnimalURL)) {
            $data['registerServiceAnimalURL'] = $this->registerServiceAnimalURL;
        }
        if (isset($this->reportLostBagURL)) {
            $data['reportLostBagURL'] = $this->reportLostBagURL;
        }
        if (isset($this->requestWheelchairURL)) {
            $data['requestWheelchairURL'] = $this->requestWheelchairURL;
        }
        if (isset($this->trackBagsURL)) {
            $data['trackBagsURL'] = $this->trackBagsURL;
        }
        if (isset($this->transitProviderEmail)) {
            $data['transitProviderEmail'] = $this->transitProviderEmail;
        }
        if (isset($this->transitProviderPhoneNumber)) {
            $data['transitProviderPhoneNumber'] = $this->transitProviderPhoneNumber;
        }
        if (isset($this->transitProviderWebsiteURL)) {
            $data['transitProviderWebsiteURL'] = $this->transitProviderWebsiteURL;
        }
        if (isset($this->upgradeURL)) {
            $data['upgradeURL'] = $this->upgradeURL;
        }

        return $data;
    }
}
