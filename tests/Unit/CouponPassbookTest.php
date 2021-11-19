<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\CouponPassbook;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Hex;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass \LauLamanApps\ApplePassbook\CouponPassbook
 */
final class CouponPassbookTest extends TestCase
{
    private const UUID = 'fd39b6b4-7181-4253-969e-5df02687c617';

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::validate
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
        $passbook = $passbook = new CouponPassbook(self::UUID);
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
            'coupon' => [],
        ];

        self::assertEquals($expected, $passbook->getData());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setLogoText
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setRelevantDate
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setBarcode
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
        $barcode->setFormat(BarcodeFormat::code128);

        $passbook->setBarcode($barcode);

        $data = $passbook->getData();
        self::assertArrayHasKey('barcode', $data);

        $expectedBarcodeData = [
            'format' => BarcodeFormat::code128->value,
            'message' => 'barcode',
            'messageEncoding' => 'iso-8859-1',
        ];
        self::assertSame($expectedBarcodeData, $data['barcode']);
        self::assertSame([$expectedBarcodeData], $data['barcodes']);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addLocation
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setMaxDistance
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setWebService
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setForegroundColor
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setBackgroundColor
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::setLabelColor
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addImage
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::getImages
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addHeaderField
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
        self::assertArrayNotHasKey('headerFields', $data['coupon']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addHeaderField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('headerFields', $data['coupon']);

        $headerFields = $data['coupon']['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addHeaderField($field2);

        $data = $passbook->getData();
        $headerFields = $data['coupon']['headerFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $headerFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $headerFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addPrimaryField
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
        self::assertArrayNotHasKey('primaryFields', $data['coupon']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addPrimaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('primaryFields', $data['coupon']);

        $primaryFields = $data['coupon']['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addPrimaryField($field2);

        $data = $passbook->getData();
        $primaryFields = $data['coupon']['primaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $primaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $primaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addHeaderField
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
        self::assertArrayNotHasKey('auxiliaryFields', $data['coupon']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addAuxiliaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('auxiliaryFields', $data['coupon']);

        $auxiliaryFields = $data['coupon']['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addAuxiliaryField($field2);

        $data = $passbook->getData();
        $auxiliaryFields = $data['coupon']['auxiliaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $auxiliaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $auxiliaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addSecondaryField
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
        self::assertArrayNotHasKey('headerFields', $data['coupon']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addSecondaryField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('secondaryFields', $data['coupon']);

        $secondaryFields = $data['coupon']['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addSecondaryField($field2);

        $data = $passbook->getData();
        $secondaryFields = $data['coupon']['secondaryFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $secondaryFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $secondaryFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::addBackField
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
        self::assertArrayNotHasKey('backFields', $data['coupon']);

        $field1 = $this->createMock(Field::class);
        $field1->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_1_METADATA>']);
        $passbook->addBackField($field1);

        $data = $passbook->getData();
        self::assertArrayHasKey('backFields', $data['coupon']);

        $backFields = $data['coupon']['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);

        $field2 = $this->createMock(Field::class);
        $field2->expects($this->atLeastOnce())->method('getMetaData')->willReturn(['<FIELD_2_METADATA>']);
        $passbook->addBackField($field2);

        $data = $passbook->getData();
        $backFields = $data['coupon']['backFields'];
        self::assertSame(['<FIELD_1_METADATA>'], $backFields[0]);
        self::assertSame(['<FIELD_2_METADATA>'], $backFields[1]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::voided
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
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::hasPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     */
    public function testHasPassTypeIdentifier(): void
    {
        $passbook = new CouponPassbook(self::UUID);

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setPassTypeIdentifier('pass.com.anonymous');

        self::assertTrue($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::hasTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::hasPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testHasTeamIdentifier(): void
    {
        $passbook = new CouponPassbook(self::UUID);
        ;

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertFalse($passbook->hasTeamIdentifier());

        $passbook->setTeamIdentifier('9X3HHK8VXA');

        self::assertFalse($passbook->hasPassTypeIdentifier());
        self::assertTrue($passbook->hasTeamIdentifier());
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     */
    public function testMissingPassTypeIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the PassTypeIdentifier before requesting the manifest data.');

        $passbook = new CouponPassbook(self::UUID);
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     */
    public function testMissingTeamIdentifierThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the TeamIdentifier before requesting the manifest data.');

        $passbook = new CouponPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::validate
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     */
    public function testMissingOrganizationNameThrowsException(): void
    {
        $this->expectException(MissingRequiredDataException::class);
        $this->expectExceptionMessage('Please specify the OrganizationName before requesting the manifest data.');

        $passbook = new CouponPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->getData();
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\CouponPassbook::validate
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

        $passbook = new CouponPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('My Awesome organization');
        $passbook->getData();
    }

    private function getValidPassbook(): CouponPassbook
    {
        $passbook = new CouponPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');

        return $passbook;
    }
}
