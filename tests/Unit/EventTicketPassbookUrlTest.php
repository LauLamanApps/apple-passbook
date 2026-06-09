<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use LauLamanApps\ApplePassbook\EventTicketPassbook;
use PHPUnit\Framework\TestCase;

final class EventTicketPassbookUrlTest extends TestCase
{
    private const UUID = 'fd39b6b4-7181-4253-969e-5df02687c617';

    public function testAccessibilityURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setAccessibilityURL('https://example.com/accessibility');

        $data = $passbook->getData();
        self::assertSame('https://example.com/accessibility', $data['accessibilityURL']);
    }

    public function testAddOnURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setAddOnURL('https://example.com/addon');

        $data = $passbook->getData();
        self::assertSame('https://example.com/addon', $data['addOnURL']);
    }

    public function testBagPolicyURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setBagPolicyURL('https://example.com/bags');

        $data = $passbook->getData();
        self::assertSame('https://example.com/bags', $data['bagPolicyURL']);
    }

    public function testContactVenueEmail(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setContactVenueEmail('venue@example.com');

        $data = $passbook->getData();
        self::assertSame('venue@example.com', $data['contactVenueEmail']);
    }

    public function testContactVenuePhoneNumber(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setContactVenuePhoneNumber('+1234567890');

        $data = $passbook->getData();
        self::assertSame('+1234567890', $data['contactVenuePhoneNumber']);
    }

    public function testContactVenueWebsite(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setContactVenueWebsite('https://example.com');

        $data = $passbook->getData();
        self::assertSame('https://example.com', $data['contactVenueWebsite']);
    }

    public function testDirectionsInformationURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setDirectionsInformationURL('https://example.com/directions');

        $data = $passbook->getData();
        self::assertSame('https://example.com/directions', $data['directionsInformationURL']);
    }

    public function testMerchandiseURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setMerchandiseURL('https://example.com/merch');

        $data = $passbook->getData();
        self::assertSame('https://example.com/merch', $data['merchandiseURL']);
    }

    public function testOrderFoodURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setOrderFoodURL('https://example.com/food');

        $data = $passbook->getData();
        self::assertSame('https://example.com/food', $data['orderFoodURL']);
    }

    public function testParkingInformationURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setParkingInformationURL('https://example.com/parking');

        $data = $passbook->getData();
        self::assertSame('https://example.com/parking', $data['parkingInformationURL']);
    }

    public function testPurchaseParkingURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setPurchaseParkingURL('https://example.com/buy-parking');

        $data = $passbook->getData();
        self::assertSame('https://example.com/buy-parking', $data['purchaseParkingURL']);
    }

    public function testSellURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setSellURL('https://example.com/sell');

        $data = $passbook->getData();
        self::assertSame('https://example.com/sell', $data['sellURL']);
    }

    public function testTransferURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTransferURL('https://example.com/transfer');

        $data = $passbook->getData();
        self::assertSame('https://example.com/transfer', $data['transferURL']);
    }

    public function testTransitInformationURL(): void
    {
        $passbook = $this->getValidPassbook();
        $passbook->setTransitInformationURL('https://example.com/transit');

        $data = $passbook->getData();
        self::assertSame('https://example.com/transit', $data['transitInformationURL']);
    }

    public function testUrlsNotPresentByDefault(): void
    {
        $passbook = $this->getValidPassbook();
        $data = $passbook->getData();

        self::assertArrayNotHasKey('accessibilityURL', $data);
        self::assertArrayNotHasKey('sellURL', $data);
        self::assertArrayNotHasKey('transferURL', $data);
    }

    private function getValidPassbook(): EventTicketPassbook
    {
        $passbook = new EventTicketPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');

        return $passbook;
    }
}
