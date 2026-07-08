<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\DateInformation;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\EntryImage;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\EntryImages;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\ImageUrlEntry;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformation\Urls;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformationEntry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpcomingPassInformationEntry::class)]
#[CoversClass(DateInformation::class)]
#[CoversClass(EntryImage::class)]
#[CoversClass(EntryImages::class)]
#[CoversClass(ImageUrlEntry::class)]
#[CoversClass(Urls::class)]
final class UpcomingPassInformationEntryTest extends TestCase
{
    public function testMinimalEntry(): void
    {
        $entry = new UpcomingPassInformationEntry('event-123', 'Summer Concert');

        self::assertSame(
            [
                'identifier' => 'event-123',
                'name' => 'Summer Concert',
                'type' => 'event',
            ],
            $entry->toArray()
        );
    }

    public function testFullEntry(): void
    {
        $entry = new UpcomingPassInformationEntry('event-123', 'Summer Concert');
        $entry->addAdditionalInfoField(new Field('doors', '19:00', 'Doors open'));
        $entry->addAuxiliaryStoreIdentifier(123456);
        $entry->addBackField(new Field('terms', 'No refunds'));
        $entry->activate();

        $dateInformation = new DateInformation(new DateTimeImmutable('2026-08-01T20:00:00+02:00'));
        $dateInformation->setTimeZone('Europe/Amsterdam');
        $entry->setDateInformation($dateInformation);

        $urls = new Urls();
        $urls->setOrderFoodURL('https://example.com/food');
        $entry->setUrls($urls);

        $data = $entry->toArray();

        self::assertSame('event-123', $data['identifier']);
        self::assertSame([['key' => 'doors', 'value' => '19:00', 'label' => 'Doors open']], $data['additionalInfoFields']);
        self::assertSame([123456], $data['auxiliaryStoreIdentifiers']);
        self::assertSame([['key' => 'terms', 'value' => 'No refunds']], $data['backFields']);
        self::assertTrue($data['isActive']);
        self::assertSame(
            ['date' => '2026-08-01T20:00:00+02:00', 'timeZone' => 'Europe/Amsterdam'],
            $data['dateInformation']
        );
        self::assertSame(['orderFoodURL' => 'https://example.com/food'], $data['URLs']);
    }

    public function testDateInformationFlags(): void
    {
        $dateInformation = new DateInformation();
        $dateInformation->ignoreTimeComponents();
        $dateInformation->isAllDay();
        $dateInformation->isUnannounced();
        $dateInformation->isUndetermined();

        self::assertSame(
            [
                'ignoreTimeComponents' => true,
                'isAllDay' => true,
                'isUnannounced' => true,
                'isUndetermined' => true,
            ],
            $dateInformation->toArray()
        );
    }

    public function testUrls(): void
    {
        $urls = new Urls();
        $urls->setAccessibilityURL('https://example.com/accessibility');
        $urls->setAddOnURL('https://example.com/add-on');
        $urls->setBagPolicyURL('https://example.com/bags');
        $urls->setContactVenueEmail('venue@example.com');
        $urls->setContactVenuePhoneNumber('+31612345678');
        $urls->setContactVenueWebsite('https://example.com');
        $urls->setDirectionsInformationURL('https://example.com/directions');
        $urls->setMerchandiseURL('https://example.com/merch');
        $urls->setOrderFoodURL('https://example.com/food');
        $urls->setParkingInformationURL('https://example.com/parking');
        $urls->setPurchaseParkingURL('https://example.com/parking/buy');
        $urls->setSellURL('https://example.com/sell');
        $urls->setTransferURL('https://example.com/transfer');
        $urls->setTransitInformationURL('https://example.com/transit');

        self::assertSame(
            [
                'accessibilityURL' => 'https://example.com/accessibility',
                'addOnURL' => 'https://example.com/add-on',
                'bagPolicyURL' => 'https://example.com/bags',
                'contactVenueEmail' => 'venue@example.com',
                'contactVenuePhoneNumber' => '+31612345678',
                'contactVenueWebsite' => 'https://example.com',
                'directionsInformationURL' => 'https://example.com/directions',
                'merchandiseURL' => 'https://example.com/merch',
                'orderFoodURL' => 'https://example.com/food',
                'parkingInformationURL' => 'https://example.com/parking',
                'purchaseParkingURL' => 'https://example.com/parking/buy',
                'sellURL' => 'https://example.com/sell',
                'transferURL' => 'https://example.com/transfer',
                'transitInformationURL' => 'https://example.com/transit',
            ],
            $urls->toArray()
        );
    }

    public function testImages(): void
    {
        $headerImage = new EntryImage();
        $headerImage->addUrl(new ImageUrlEntry('https://example.com/header.png', 'abc123', 2.0, 1024));

        $venueMap = new EntryImage();
        $venueMap->reuseExisting();

        $images = new EntryImages();
        $images->setHeaderImage($headerImage);
        $images->setVenueMap($venueMap);

        $entry = new UpcomingPassInformationEntry('event-123', 'Summer Concert');
        $entry->setImages($images);

        self::assertSame(
            [
                'headerImage' => [
                    'URLs' => [
                        [
                            'URL' => 'https://example.com/header.png',
                            'SHA256' => 'abc123',
                            'scale' => 2.0,
                            'size' => 1024,
                        ],
                    ],
                ],
                'venueMap' => [
                    'reuseExisting' => true,
                ],
            ],
            $entry->toArray()['images']
        );
    }

    public function testImageUrlEntryRequiresHttps(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ImageUrlEntry('http://example.com/header.png', 'abc123');
    }
}
