<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use LauLamanApps\ApplePassbook\BoardingPassbook;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;
use PHPUnit\Framework\TestCase;

final class BoardingPassbookUrlTest extends TestCase
{
    private const UUID = 'fd39b6b4-7181-4253-969e-5df02687c617';

    public function testChangeSeatURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setChangeSeatURL('https://example.com/change-seat');

        $data = $passbook->getData();
        self::assertSame('https://example.com/change-seat', $data['changeSeatURL']);
    }

    public function testEntertainmentURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setEntertainmentURL('https://example.com/entertainment');

        $data = $passbook->getData();
        self::assertSame('https://example.com/entertainment', $data['entertainmentURL']);
    }

    public function testManagementURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setManagementURL('https://example.com/manage');

        $data = $passbook->getData();
        self::assertSame('https://example.com/manage', $data['managementURL']);
    }

    public function testPurchaseAdditionalBaggageURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setPurchaseAdditionalBaggageURL('https://example.com/baggage');

        $data = $passbook->getData();
        self::assertSame('https://example.com/baggage', $data['purchaseAdditionalBaggageURL']);
    }

    public function testPurchaseLoungeAccessURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setPurchaseLoungeAccessURL('https://example.com/lounge');

        $data = $passbook->getData();
        self::assertSame('https://example.com/lounge', $data['purchaseLoungeAccessURL']);
    }

    public function testPurchaseWifiURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setPurchaseWifiURL('https://example.com/wifi');

        $data = $passbook->getData();
        self::assertSame('https://example.com/wifi', $data['purchaseWifiURL']);
    }

    public function testUpgradeURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setUpgradeURL('https://example.com/upgrade');

        $data = $passbook->getData();
        self::assertSame('https://example.com/upgrade', $data['upgradeURL']);
    }

    public function testTransitProviderEmail(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTransitProviderEmail('info@airline.com');

        $data = $passbook->getData();
        self::assertSame('info@airline.com', $data['transitProviderEmail']);
    }

    public function testTransitProviderPhoneNumber(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTransitProviderPhoneNumber('+1234567890');

        $data = $passbook->getData();
        self::assertSame('+1234567890', $data['transitProviderPhoneNumber']);
    }

    public function testTransitProviderWebsiteURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTransitProviderWebsiteURL('https://airline.com');

        $data = $passbook->getData();
        self::assertSame('https://airline.com', $data['transitProviderWebsiteURL']);
    }

    public function testTrackBagsURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTrackBagsURL('https://example.com/track-bags');

        $data = $passbook->getData();
        self::assertSame('https://example.com/track-bags', $data['trackBagsURL']);
    }

    public function testRegisterServiceAnimalURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setRegisterServiceAnimalURL('https://example.com/service-animal');

        $data = $passbook->getData();
        self::assertSame('https://example.com/service-animal', $data['registerServiceAnimalURL']);
    }

    public function testReportLostBagURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setReportLostBagURL('https://example.com/lost-bag');

        $data = $passbook->getData();
        self::assertSame('https://example.com/lost-bag', $data['reportLostBagURL']);
    }

    public function testRequestWheelchairURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setRequestWheelchairURL('https://example.com/wheelchair');

        $data = $passbook->getData();
        self::assertSame('https://example.com/wheelchair', $data['requestWheelchairURL']);
    }

    public function testUrlsNotPresentByDefault(): void
    {
        $passbook = $this->getValidPassbook();
        $data = $passbook->getData();

        self::assertArrayNotHasKey('changeSeatURL', $data);
        self::assertArrayNotHasKey('upgradeURL', $data);
        self::assertArrayNotHasKey('transitProviderEmail', $data);
    }

    private function getValidPassbook(): BoardingPassbook
    {
        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');
        $passbook->setTransitType(TransitType::Air);

        return $passbook;
    }
}
