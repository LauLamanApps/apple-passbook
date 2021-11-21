<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use DateTimeImmutable;
use DateTimeInterface;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightNumber;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiAccess;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiNetwork;
use LauLamanApps\ApplePassbook\Passbook;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Hex;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass Passbook
 */
final class PassbookTest extends TestCase
{
    private const UUID = 'fd39b6b4-7181-4253-969e-5df02687c617';
    public const ANONYMOUS_PASSBOOK_TYPE = 'test';

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testDefaults(): void
    {
        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');

        $expected = [
            'formatVersion' => 1,
            'passTypeIdentifier' => 'pass.com.anonymous',
            'serialNumber' => self::UUID,
            'teamIdentifier' => '9X3HHK8VXA',
            'organizationName' => 'LauLaman Apps',
            'description' => 'Pass for LauLaman Apps',
            self::ANONYMOUS_PASSBOOK_TYPE => [],
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::setLogoText
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setAppLaunchURL
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
    public function testSetAppLaunchURL(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('appLaunchURL', $data);

        $passbook->setAppLaunchURL('app://your.app.url');

        $data = $passbook->getData();
        self::assertArrayHasKey('appLaunchURL', $data);
        self::assertSame('app://your.app.url', $data['appLaunchURL']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addAssociatedStoreIdentifiers
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
    public function testAddAssociatedStoreIdentifiers(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('associatedStoreIdentifiers', $data);

        $passbook->addAssociatedStoreIdentifiers(123);

        $data = $passbook->getData();
        self::assertArrayHasKey('associatedStoreIdentifiers', $data);
        self::assertSame([123], $data['associatedStoreIdentifiers']);

        $passbook->addAssociatedStoreIdentifiers(987);

        $data = $passbook->getData();
        self::assertSame([123, 987], $data['associatedStoreIdentifiers']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::setUserInfo
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
    public function testSetUserInfo(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('userInfo', $data);

        $passbook->setUserInfo('{"jsonData":"your data"}');

        $data = $passbook->getData();
        self::assertArrayHasKey('userInfo', $data);
        self::assertSame('{"jsonData":"your data"}', $data['userInfo']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::setRelevantDate
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setBarcode
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

        $barcode =  new Barcode();
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::addLocation
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setMaxDistance
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setWebService
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setForegroundColor
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setBackgroundColor
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::setLabelColor
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::addImage
     * @covers \LauLamanApps\ApplePassbook\Passbook::getImages
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::addHeaderField
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
        self::assertArrayNotHasKey('headerFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addHeaderField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('headerFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $headerFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addHeaderField($field2);

        $data = $passbook->getData();
        $headerFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $headerFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addPrimaryField
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
        self::assertArrayNotHasKey('primaryFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addPrimaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('primaryFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $primaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addPrimaryField($field2);

        $data = $passbook->getData();
        $primaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $primaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addHeaderField
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
        self::assertArrayNotHasKey('auxiliaryFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addAuxiliaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('auxiliaryFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $auxiliaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addAuxiliaryField($field2);

        $data = $passbook->getData();
        $auxiliaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $auxiliaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addSecondaryField
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
        self::assertArrayNotHasKey('headerFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addSecondaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('secondaryFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $secondaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addSecondaryField($field2);

        $data = $passbook->getData();
        $secondaryFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $secondaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addBackField
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
        self::assertArrayNotHasKey('backFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addBackField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('backFields', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $backFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addBackField($field2);

        $data = $passbook->getData();
        $backFields = $data[self::ANONYMOUS_PASSBOOK_TYPE]['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $backFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::voided
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
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     */
    public function testHasPassTypeIdentifier(): void
    {
        $passbook = $this->getAnonymousPassbook();

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setPassTypeIdentifier('pass.com.anonymous');

        self::assertTrue($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testHasTeamIdentifier(): void
    {
        $passbook = $this->getAnonymousPassbook();

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setTeamIdentifier('9X3HHK8VXA');

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertTrue($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     */
    public function testConstTypeNotImplementedThrowsException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Please implement protected const TYPE in class.');

        $passbook = $this->getAnonymousPassbook();

        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     */
    public function testMissingPassTypeIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the PassTypeIdentifier before requesting the manifest data.');

        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     */
    public function testMissingTeamIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TeamIdentifier before requesting the manifest data.');

        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\GenericPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testMissingOrganizationNameThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the OrganizationName before requesting the manifest data.');

        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\GenericPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testMissingDescriptionThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the Description before requesting the manifest data.');

        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->getData();
    }

    private function getAnonymousPassbook(): Passbook
    {
        return new class(self::UUID) extends Passbook {
        };
    }

    private function getAnonymousPassbookWithConst(): Passbook
    {
        return new class(self::UUID) extends Passbook {
            protected const TYPE = PassbookTest::ANONYMOUS_PASSBOOK_TYPE;
        };
    }

    /**
     * @return Passbook
     */
    private function getValidPassbook(): Passbook
    {
        $passbook = $this->getAnonymousPassbookWithConst();
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');

        return $passbook;
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::setExpirationDate
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
    public function testSetExpirationDate(): void
    {

        $expirationDate = new DateTimeImmutable('now');

        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('expirationDate', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $passbook->setExpirationDate($expirationDate);

        $data = $passbook->getData();
        self::assertArrayHasKey('expirationDate', $data);
        self::assertSame($expirationDate->format(DateTimeInterface::W3C), $data['expirationDate']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Passbook::addSemanticTag
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
    public function testAddSemanticTag(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('semantics', $data[self::ANONYMOUS_PASSBOOK_TYPE]);

        $semanticTagMock1 = $this->createMock(SemanticTag::class);
        $semanticTagMock1->expects($this->once())->method('getKey')->willReturn('<SemanticTag1Key>');
        $semanticTagMock1->expects($this->once())->method('getValue')->willReturn('<SemanticTag1Value>');
        $semanticTagMock2 = $this->createMock(SemanticTag::class);
        $semanticTagMock2->expects($this->once())->method('getKey')->willReturn('<SemanticTag2Key>');
        $semanticTagMock2->expects($this->once())->method('getValue')->willReturn('<SemanticTag2Value>');
        $semanticTagMock3 = $this->createMock(SemanticTag::class);
        $semanticTagMock3->expects($this->once())->method('getKey')->willReturn('<SemanticTag3Key>');
        $semanticTagMock3->expects($this->once())->method('getValue')->willReturn('<SemanticTag3Value>');

        $passbook->addSemanticTag($semanticTagMock1);
        $passbook->addSemanticTag($semanticTagMock2);
        $passbook->addSemanticTag($semanticTagMock3);

        $data = $passbook->getData();
        self::assertArrayHasKey('semantics', $data);

        $expected = [
            '<SemanticTag1Key>' => '<SemanticTag1Value>',
            '<SemanticTag2Key>' => '<SemanticTag2Value>',
            '<SemanticTag3Key>' => '<SemanticTag3Value>',
        ];
        self::assertEquals($expected, $data['semantics']);
    }
}
