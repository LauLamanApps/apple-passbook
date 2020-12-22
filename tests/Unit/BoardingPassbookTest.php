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
        $passbook = new BoardingPassbook(self::UUID, TransitType::air());
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
            'boardingPass' => [
                'transitType' => TransitType::air()->getValue(),
            ],
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setLogoText
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testSetRelevantDate(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('relevantDate', $data);

        /** @phpstan-ignore-next-line Ignore false return type */
        $passbook->setRelevantDate(DateTimeImmutable::createFromFormat(DateTimeImmutable::W3C, '2019-11-08T15:55:00Z'));

        $data = $passbook->getData();
        self::assertArrayHasKey('relevantDate', $data);
        self::assertSame('2019-11-08T15:55:00+00:00', $data['relevantDate']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setBarcode
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\MetaData\Barcode::__construct
     * @covers \LauLamanApps\ApplePassbook\MetaData\Barcode::setFormat
     * @covers \LauLamanApps\ApplePassbook\MetaData\Barcode::setMessage
     * @covers \LauLamanApps\ApplePassbook\MetaData\Barcode::toArray
     * @covers \LauLamanApps\ApplePassbook\MetaData\Barcode::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\MetaData\Location::__construct
     * @covers \LauLamanApps\ApplePassbook\MetaData\Location::toArray
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::__construct
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::toString
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::__construct
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::toString
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::__construct
     * @covers \LauLamanApps\ApplePassbook\Style\Color\Hex::toString
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::addAuxiliaryField
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::setTransitType
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
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
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     */
    public function testHasPassTypeIdentifier(): void
    {
        $passbook = new BoardingPassbook(self::UUID);

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setPassTypeIdentifier('pass.com.anonymous');

        self::assertTrue($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testHasTeamIdentifier(): void
    {
        $passbook = new BoardingPassbook(self::UUID);
        ;

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setTeamIdentifier('9X3HHK8VXA');

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertTrue($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testMissingPassTypeIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the PassTypeIdentifier before requesting the manifest data.');

        $passbook = new BoardingPassbook(self::UUID);
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testMissingTeamIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TeamIdentifier before requesting the manifest data.');

        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testMissingOrganizationNameThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the OrganizationName before requesting the manifest data.');

        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::__construct
     * @covers \LauLamanApps\ApplePassbook\BoardingPassbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testMissingDescriptionThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the Description before requesting the manifest data.');

        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->getData();
    }

    public function testMissingTransitTypeThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TransitType before requesting the manifest data.');

        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setPassTypeIdentifier('pass.com.klm.mobile.iphone.klmmobile.boardingpass');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->setDescription('My description for pass');
        $passbook->getData();
    }

    public function testPassbook(): void
    {
        $passbook = new BoardingPassbook('gT6zrHkaW');
        $passbook->setTeamIdentifier('A93A5CM278');
        $passbook->setPassTypeIdentifier('pass.com.apple.devpubs.example');
        $passbook->setTransitType(TransitType::air());
        $passbook->setOrganizationName('Skyport Airways');
        $passbook->setDescription('Skyport Boarding Pass');
        $passbook->setLogoText('Skyport Airways');
        $passbook->addLocation(new Location(37.6189722, -122.3748889));
        $passbook->setForegroundColor(new Rgb(22, 55, 110));
        $passbook->setBackgroundColor(new Rgb(50, 91, 185));
        $passbook->setRelevantDate(new DateTimeImmutable( '2012-07-22T14:25-08:00'));
        $passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

        $barcode = new Barcode();
        $barcode->setFormat(BarcodeFormat::pdf417());
        $barcode->setMessage('SFOJFK JOHN APPLESEED LH451 2012-07-22T14:25-08:00');
        $passbook->setBarcode($barcode);

        $gate = new Field();
        $gate->setKey('gate');
        $gate->setLabel('GATE');
        $gate->setValue('23');
        $gate->setChangeMessage('Gate changed to %@.');
        $passbook->addHeaderField($gate);

        $depart = new Field();
        $depart->setKey('depart');
        $depart->setLabel('SAN FRANCISCO');
        $depart->setValue('SFO');
        $passbook->addPrimaryField($depart);

        $arrive = new Field();
        $arrive->setKey('arrive');
        $arrive->setLabel('NEW YORK');
        $arrive->setValue('JFK');
        $passbook->addPrimaryField($arrive);

        $passenger = new Field();
        $passenger->setKey('passenger');
        $passenger->setLabel('PASSENGER');
        $passenger->setValue('John Appleseed');
        $passbook->addSecondaryField($passenger);

        $boardingTime = new Field();
        $boardingTime->setKey('boardingTime');
        $boardingTime->setLabel('DEPART');
        $boardingTime->setValue('2:25 PM');
        $boardingTime->setChangeMessage('Boarding time changed to %@.');
        $passbook->addAuxiliaryField($boardingTime);

        $flightNewName = new Field();
        $flightNewName->setKey('flightNewName');
        $flightNewName->setLabel('FLIGHT');
        $flightNewName->setValue('815');
        $flightNewName->setChangeMessage('Flight number changed to %@');
        $passbook->addAuxiliaryField($flightNewName);

        $class = new Field();
        $class->setKey('class');
        $class->setLabel('DESIG.');
        $class->setValue('Coach');
        $passbook->addAuxiliaryField($class);

        $date = new Field();
        $date->setKey('date');
        $date->setLabel('DATE');
        $date->setValue('7/22');
        $passbook->addAuxiliaryField($date);

        $passport = new Field();
        $passport->setKey('passport');
        $passport->setLabel('PASSPORT');
        $passport->setValue('Canadian/Canadien');
        $passbook->addBackField($passport);

        $residence = new Field();
        $residence->setKey('residence');
        $residence->setLabel('RESIDENCE');
        $residence->setValue('999 Infinite Loop, Apartment 42, Cupertino CA');
        $passbook->addBackField($residence);

        $expected = [
            "formatVersion" => 1,
            "passTypeIdentifier" => "pass.com.apple.devpubs.example",
            "serialNumber" => "gT6zrHkaW",
            "teamIdentifier" => "A93A5CM278",
            "webServiceURL" => "https://example.com/passes/",
            "authenticationToken" => "vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc",
            "relevantDate" => "2012-07-22T14:25:00-08:00",
            "locations" => [
                [
                    "longitude" => -122.3748889,
                    "latitude" => 37.6189722
                ]
            ],
            "barcode" => [
                "message" => "SFOJFK JOHN APPLESEED LH451 2012-07-22T14:25-08:00",
                "format" => "PKBarcodeFormatPDF417",
                "messageEncoding" => "iso-8859-1"
            ],
            "barcodes" =>[
                [
                    "message" => "SFOJFK JOHN APPLESEED LH451 2012-07-22T14:25-08:00",
                    "format" => "PKBarcodeFormatPDF417",
                    "messageEncoding" => "iso-8859-1"
                ],
            ],
            "organizationName" => "Skyport Airways",
            "description" => "Skyport Boarding Pass",
            "logoText" => "Skyport Airways",
            "foregroundColor" => "rgb(22, 55, 110)",
            "backgroundColor" => "rgb(50, 91, 185)",
            "boardingPass" => [
                'transitType' => 'PKTransitTypeAir',
                "headerFields" => [
                    [
                        "label" => "GATE",
                        "key" => "gate",
                        "value" => "23",
                        "changeMessage" => "Gate changed to %@."
                    ]
                ],
                "primaryFields" => [
                    [
                        "key" => "depart",
                        "label" => "SAN FRANCISCO",
                        "value" => "SFO"
                    ],
                    [
                        "key" => "arrive",
                        "label" => "NEW YORK",
                        "value" => "JFK"
                    ]
                ],
                "secondaryFields" => [
                    [
                        "key" => "passenger",
                        "label" => "PASSENGER",
                        "value" => "John Appleseed"
                    ]
                ],
                "auxiliaryFields" => [
                    [
                        "label" => "DEPART",
                        "key" => "boardingTime",
                        "value" =>  "2:25 PM",
                        "changeMessage" => "Boarding time changed to %@."
                    ],
                    [
                        "label" => "FLIGHT",
                        "key" => "flightNewName",
                        "value" => "815",
                        "changeMessage" => "Flight number changed to %@"
                    ],
                    [
                        "key" => "class",
                        "label" => "DESIG.",
                        "value" => "Coach"
                    ],
                    [
                        "key" => "date",
                        "label" => "DATE",
                        "value" =>  "7/22",
                    ]
                ],
                "backFields" => [
                    [
                        "key" => "passport",
                        "label" => "PASSPORT",
                        "value" => "Canadian/Canadien"
                    ],
                    [
                        "key" => "residence",
                        "label" => "RESIDENCE",
                        "value" => "999 Infinite Loop, Apartment 42, Cupertino CA"
                    ]
                ]
            ]
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    private function getValidPassbook(): BoardingPassbook
    {
        $passbook = new BoardingPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');
        $passbook->setTransitType(TransitType::air());

        return $passbook;
    }
}
