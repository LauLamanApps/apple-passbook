<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\BoardingPassbook;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Hex;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class BoardingPassbookTest extends TestCase
{
    private const UUID = 'f8c4a300-151d-4fb3-b879-1b553d83ccf6';

    public function testDefaults(): void
    {
        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');
        $passbook->setTransitType(TransitType::air());

        $expected = [
            'formatVersion' => 1,
            'passTypeIdentifier' => 'pass.com.anonymous',
            'serialNumber' => self::UUID,
            'teamIdentifier' => '9X3HHK8VXA',
            'organizationName' => 'LauLaman Apps',
            'description' => 'Pass for LauLaman Apps',
            'transitType' => TransitType::air()->getValue(),
            'boardingPass' => [],
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setLogoText
     */
    public function testSetLogoText(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('logoText', $data);

        $passbook->setLogoText('Some Text LoGo');

        $data = $passbook->getData();
        self::assertArrayHasKey('logoText', $data);
        self::assertSame('Some Text LoGo', $data['logoText']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setRelevantDate
     */
    public function testSetRelevantDate(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('relevantDate', $data);

        $passbook->setRelevantDate(DateTimeImmutable::createFromFormat(DateTimeImmutable::W3C, '2019-11-08T15:55:00Z'));

        $data = $passbook->getData();
        self::assertArrayHasKey('relevantDate', $data);
        self::assertSame('2019-11-08T15:55:00+00:00', $data['relevantDate']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setBarcode
     */
    public function testSetBarcode(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('barcode', $data);
        self::assertArrayNotHasKey('barcodes', $data);

        $barcode = new Barcode();
        $barcode->setMessage('barcode');
        $barcode->setFormat(BarcodeFormat::code128());

        $passbook->setBarcode($barcode);

        $data = $passbook->getData();
        self::assertArrayHasKey('barcode', $data);

        $expectedBarcodeData = [
            'format' => BarcodeFormat::code128()->getValue(),
            'message' => 'barcode',
            'messageEncoding' => 'iso-8859-1',
        ];
        self::assertSame($expectedBarcodeData, $data['barcode']);
        self::assertSame([$expectedBarcodeData], $data['barcodes']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addLocation
     */
    public function testAddLocation(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('locations', $data);

        $location1 = new Location(12.34, 56.78);
        $passbook->addLocation($location1);

        $expectedLocation1Data = [
            'latitude' => 12.34,
            'longitude' => 56.78,
        ];

        $data = $passbook->getData();
        self::assertArrayHasKey('locations', $data);
        self::assertSame([$expectedLocation1Data], $data['locations']);

        $location2 = new Location(90.21, 54.67);
        $passbook->addLocation($location2);

        $expectedLocation2Data = [
            'latitude' => 90.21,
            'longitude' => 54.67,
        ];

        $data = $passbook->getData();
        self::assertArrayHasKey('locations', $data);
        self::assertSame([$expectedLocation1Data, $expectedLocation2Data], $data['locations']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setMaxDistance
     */
    public function testSetMaxDistance(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('maxDistance', $data);

        $passbook->setMaxDistance(123);

        $data = $passbook->getData();
        self::assertArrayHasKey('maxDistance', $data);
        self::assertSame(123, $data['maxDistance']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setWebService
     */
    public function testSetWebService(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('webServiceURL', $data);
        self::assertArrayNotHasKey('authenticationToken', $data);

        $passbook->setWebService('https://example.com', 'authToken');

        $data = $passbook->getData();
        self::assertArrayHasKey('webServiceURL', $data);
        self::assertArrayHasKey('authenticationToken', $data);
        self::assertSame('https://example.com', $data['webServiceURL']);
        self::assertSame('authToken', $data['authenticationToken']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setForegroundColor
     */
    public function testSetForegroundColor(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('foregroundColor', $data);

        $passbook->setForegroundColor(new Hex('1100ff'));

        $data = $passbook->getData();
        self::assertArrayHasKey('foregroundColor', $data);
        self::assertSame('#1100ff', $data['foregroundColor']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setBackgroundColor
     */
    public function testSetBackgroundColor(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('backgroundColor', $data);

        $passbook->setBackgroundColor(new Hex('1100ff'));

        $data = $passbook->getData();
        self::assertArrayHasKey('backgroundColor', $data);
        self::assertSame('#1100ff', $data['backgroundColor']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setLabelColor
     */
    public function testSetLabelColor(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('labelColor', $data);

        $passbook->setLabelColor(new Hex('1100ff'));

        $data = $passbook->getData();
        self::assertArrayHasKey('labelColor', $data);
        self::assertSame('#1100ff', $data['labelColor']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addImage
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getImages
     */
    public function testAddImage(): void
    {
        $passbook = $this->getValidPassbook();

        self::assertEmpty($passbook->getImages());

        $image1 = $this->createMock(Image::class);
        $passbook->addImage($image1);

        self::assertSame([$image1], $passbook->getImages());

        $image2 = $this->createMock(Image::class);
        $passbook->addImage($image2);

        self::assertSame([$image1, $image2], $passbook->getImages());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addHeaderField
     */
    public function testAddHeaderField(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('headerFields', $data['boardingPass']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addHeaderField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('headerFields', $data['boardingPass']);

        $headerFields = $data['boardingPass']['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addHeaderField($field2);

        $data = $passbook->getData();
        $headerFields = $data['boardingPass']['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $headerFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addPrimaryField
     */
    public function testAddPrimaryField(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('primaryFields', $data['boardingPass']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addPrimaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('primaryFields', $data['boardingPass']);

        $primaryFields = $data['boardingPass']['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addPrimaryField($field2);

        $data = $passbook->getData();
        $primaryFields = $data['boardingPass']['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $primaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addHeaderField
     */
    public function testAddAuxiliaryField(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('auxiliaryFields', $data['boardingPass']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addAuxiliaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('auxiliaryFields', $data['boardingPass']);

        $auxiliaryFields = $data['boardingPass']['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addAuxiliaryField($field2);

        $data = $passbook->getData();
        $auxiliaryFields = $data['boardingPass']['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $auxiliaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addSecondaryField
     */
    public function testAddSecondaryField(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('headerFields', $data['boardingPass']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addSecondaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('secondaryFields', $data['boardingPass']);

        $secondaryFields = $data['boardingPass']['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addSecondaryField($field2);

        $data = $passbook->getData();
        $secondaryFields = $data['boardingPass']['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $secondaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::addBackField
     */
    public function testAddBackField(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('backFields', $data['boardingPass']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addBackField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('backFields', $data['boardingPass']);

        $backFields = $data['boardingPass']['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addBackField($field2);

        $data = $passbook->getData();
        $backFields = $data['boardingPass']['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $backFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::voided
     */
    public function testVoided(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('voided', $data);

        $passbook->voided();

        $data = $passbook->getData();
        self::assertArrayHasKey('voided', $data);
        self::assertTrue($data['voided']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::hasPassTypeIdentifier
     */
    public function testHasPassTypeIdentifier(): void
    {
        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setPassTypeIdentifier('pass.com.anonymous');

        self::assertTrue($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::hasTeamIdentifier
     */
    public function testHasTeamIdentifier(): void
    {
        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));;

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setTeamIdentifier('9X3HHK8VXA');

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertTrue($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     */
    public function testMissingPassTypeIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the PassTypeIdentifier before requesting the manifest data.');

        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     */
    public function testMissingTeamIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TeamIdentifier before requesting the manifest data.');

        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     */
    public function testMissingOrganizationNameThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the OrganizationName before requesting the manifest data.');

        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     */
    public function testMissingDescriptionThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the Description before requesting the manifest data.');

        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->getData();
    }

    public function testMissingTransitTypeThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TransitType before requesting the manifest data.');

        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setPassTypeIdentifier('pass.com.klm.mobile.iphone.klmmobile.boardingpass');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->setDescription('My description for pass');
        $passbook->getData();
    }

    public function testPassbook():void
    {
        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setPassTypeIdentifier('pass.com.klm.mobile.iphone.klmmobile.boardingpass');
        $passbook->setTransitType(TransitType::air());
        $passbook->setOrganizationName('KLM');
        $passbook->setDescription('KLM Boarding Pass');
        $passbook->addLocation(new Location(52.308333, 4.768056));
        $passbook->setForegroundColor(new Hex('031e2F'));
        $passbook->setBackgroundColor(new Rgb(255, 255, 255));
        $passbook->setLabelColor(new Hex('031e2F'));
        $passbook->setRelevantDate(DateTimeImmutable::createFromFormat(DateTimeImmutable::W3C, '2019-11-08T15:55:00Z'));
        $passbook->setWebService('https://apiams.airfranceklm.com/wallet', 'KL07424264229561');

        $barcode = new Barcode();
        $barcode->setFormat(BarcodeFormat::aztec());
        $barcode->setMessage('M1LAMAN/LAURENS       EM3QJPJ AMSBCNKL 1675 312M021B0029 31F>60B  M     KL 0E07424264229560');
        $barcode->setAltText('SEC.KL1675: 029');
        $passbook->setBarcode($barcode);

        $date = new Field();
        $date->setKey('date');
        $date->setLabel('Date');
        $date->setValue('08 Nov');
        $date->setTextAlignment(TextAlignment::left());
        $passbook->addHeaderField($date);

        $gate = new Field();
        $gate->setKey('gate');
        $gate->setLabel('Gate');
        $gate->setValue('D79');
        $gate->setTextAlignment(TextAlignment::left());
        $passbook->addHeaderField($gate);

        $booking = new Field();
        $booking->setKey('booking');
        $booking->setLabel('Booking');
        $booking->setValue('M3QJPJ');
        $booking->setTextAlignment(TextAlignment::left());
        $passbook->addBackField($booking);

        $ticket = new Field();
        $ticket->setKey('ticket');
        $ticket->setLabel('Ticket');
        $ticket->setValue('074 2426422956');
        $ticket->setTextAlignment(TextAlignment::left());
        $passbook->addBackField($ticket);

        $class = new Field();
        $class->setKey('class');
        $class->setLabel('Class');
        $class->setValue('ECONOMY');
        $class->setTextAlignment(TextAlignment::left());
        $passbook->addBackField($class);

        $contact = new Field();
        $contact->setKey('contact');
        $contact->setLabel('Contact us');
        $contact->setValue('https://www.klm.com/travel/nl_nl/customer_support/customer_support/contact/about/checkin_online.htm');
        $contact->setAttributedValue('<a href=\'https://www.klm.com/travel/nl_nl/customer_support/customer_support/contact/about/checkin_online.htm\'>We are happy to help you! Contact us 24/7</a>');
        $contact->setTextAlignment(TextAlignment::left());
        $passbook->addBackField($contact);

        $origin = new Field();
        $origin->setKey('origin');
        $origin->setLabel('Amsterdam');
        $origin->setValue('AMS');
        $origin->setTextAlignment(TextAlignment::left());
        $passbook->addPrimaryField($origin);

        $destination = new Field();
        $destination->setKey('destination');
        $destination->setLabel('Barcelona');
        $destination->setValue('BCN');
        $destination->setTextAlignment(TextAlignment::left());
        $passbook->addPrimaryField($destination);

        $passenger = new Field();
        $passenger->setKey('passenger');
        $passenger->setLabel('Passenger');
        $passenger->setValue('LAURENS LAMAN');
        $passenger->setTextAlignment(TextAlignment::left());
        $passbook->addPrimaryField($passenger);

        $seat = new Field();
        $seat->setKey('seat');
        $seat->setLabel('Seat');
        $seat->setValue('21B');
        $seat->setTextAlignment(TextAlignment::natural());
        $passbook->addPrimaryField($seat);

        $class = new Field();
        $class->setKey('class');
        $class->setLabel('Class');
        $class->setValue('M');
        $class->setTextAlignment(TextAlignment::right());
        $passbook->addPrimaryField($class);

        $flightNumber = new Field();
        $flightNumber->setKey('flightNumber');
        $flightNumber->setLabel('Flight');
        $flightNumber->setValue('KL1675');
        $flightNumber->setTextAlignment(TextAlignment::left());
        $passbook->addAuxiliaryField($flightNumber);

        $board = new Field();
        $board->setKey('board');
        $board->setLabel('Board');
        $board->setValue('16:27');
        $board->setTextAlignment(TextAlignment::left());
        $passbook->addAuxiliaryField($board);

        $depart = new Field();
        $depart->setKey('depart');
        $depart->setLabel('Depart');
        $depart->setValue('16:55');
        $depart->setTextAlignment(TextAlignment::left());
        $passbook->addAuxiliaryField($depart);

        $expected = [
            'formatVersion' => 1,
            'passTypeIdentifier' => 'pass.com.klm.mobile.iphone.klmmobile.boardingpass',
            'serialNumber' => 'f8c4a300-151d-4fb3-b879-1b553d83ccf6',
            'teamIdentifier' => '9X3HHK8VXA',
            'organizationName' => 'KLM',
            'description' => 'KLM Boarding Pass',
            'transitType' => 'PKTransitTypeAir',
            'barcode' => [
                'format' => 'PKBarcodeFormatAztec',
                'message' => 'M1LAMAN/LAURENS       EM3QJPJ AMSBCNKL 1675 312M021B0029 31F>60B  M     KL 0E07424264229560',
                'messageEncoding' => 'iso-8859-1',
                'altText' => 'SEC.KL1675: 029',
            ],
            'barcodes' => [
                [
                    'format' => 'PKBarcodeFormatAztec',
                    'message' => 'M1LAMAN/LAURENS       EM3QJPJ AMSBCNKL 1675 312M021B0029 31F>60B  M     KL 0E07424264229560',
                    'messageEncoding' => 'iso-8859-1',
                    'altText' => 'SEC.KL1675: 029',
                ],
            ],
            'relevantDate' => '2019-11-08T15:55:00+00:00',
            'locations' => [
                [
                    'latitude' => 52.308333,
                    'longitude' => 4.768056,
                ],
            ],
            'webServiceURL' => 'https://apiams.airfranceklm.com/wallet',
            'authenticationToken' => 'KL07424264229561',
            'foregroundColor' => '#031e2f',
            'backgroundColor' => 'rgb(255, 255, 255)',
            'labelColor' => '#031e2f',
            'boardingPass' => [
                'headerFields' => [
                    [
                        'key' => 'date',
                        'value' => '08 Nov',
                        'label' => 'Date',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'gate',
                        'value' => 'D79',
                        'label' => 'Gate',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                ],
                'primaryFields' => [
                    [
                        'key' => 'origin',
                        'value' => 'AMS',
                        'label' => 'Amsterdam',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'destination',
                        'value' => 'BCN',
                        'label' => 'Barcelona',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'passenger',
                        'value' => 'LAURENS LAMAN',
                        'label' => 'Passenger',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'seat',
                        'value' => '21B',
                        'label' => 'Seat',
                        'textAlignment' => 'PKTextAlignmentNatural',
                    ],
                    [
                        'key' => 'class',
                        'value' => 'M',
                        'label' => 'Class',
                        'textAlignment' => 'PKTextAlignmentRight',
                    ],
                ],
                'auxiliaryFields' => [
                    [
                        'key' => 'flightNumber',
                        'value' => 'KL1675',
                        'label' => 'Flight',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'board',
                        'value' => '16:27',
                        'label' => 'Board',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'depart',
                        'value' => '16:55',
                        'label' => 'Depart',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'booking',
                        'value' => 'M3QJPJ',
                        'label' => 'Booking',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'ticket',
                        'value' => '074 2426422956',
                        'label' => 'Ticket',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'class',
                        'value' => 'ECONOMY',
                        'label' => 'Class',
                        'textAlignment' => 'PKTextAlignmentLeft',
                    ],
                    [
                        'key' => 'contact',
                        'value' => 'https://www.klm.com/travel/nl_nl/customer_support/customer_support/contact/about/checkin_online.htm',
                        'label' => 'Contact us',
                        'textAlignment' => 'PKTextAlignmentLeft',
                        'attributedValue' => '<a href=\'https://www.klm.com/travel/nl_nl/customer_support/customer_support/contact/about/checkin_online.htm\'>We are happy to help you! Contact us 24/7</a>',
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    private function getValidPassbook(): BoardingPassbook
    {
        $passbook = new BoardingPassbook(Uuid::fromString(self::UUID));
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');
        $passbook->setTransitType(TransitType::air());

        return $passbook;
    }
}
