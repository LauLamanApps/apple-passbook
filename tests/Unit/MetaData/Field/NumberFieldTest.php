<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\NumberField;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\Field\NumberField;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\NumberStyle;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use LogicException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class NumberFieldTest extends TestCase
{
    public function testSetLabel(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setLabel('Some label');

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'label' => 'Some label'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetDataDetectorTypes(): void
    {
        $field = new NumberField('some_key', 123);
        $field->addDataDetectorType(DataDetector::address);

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'dataDetectorTypes' => [DataDetector::address->value]
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetChangeMessage(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setChangeMessage('Gate changed to %s');

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'changeMessage' => 'Gate changed to %s'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetTextAlignment(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setTextAlignment(TextAlignment::center);

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'textAlignment' => TextAlignment::center->value
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetAttributedValue(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setAttributedValue('Some attribute value');

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'attributedValue' => 'Some attribute value'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetCurrencyCode(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setCurrencyCode('EUR');

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'currencyCode' => 'EUR'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetNumberStyle(): void
    {
        $field = new NumberField('some_key', 123);
        $field->setNumberStyle(NumberStyle::decimal);

        $expected = [
            'key' => 'some_key',
            'value' => 123,
            'numberStyle' => NumberStyle::decimal->value,
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetNumberStyleAfterSettingCurrencyCodeThrowsLogicException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('You can not set both a \'currencyCode\' and a \'numberStyle\'. Please set only one of the 2.');

        $field = new NumberField('some_key', 123);
        $field->setCurrencyCode('EUR');
        $field->setNumberStyle(NumberStyle::decimal);
    }

    public function testSetCurrencyCodeAfterSettingNumberStyleThrowsLogicException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('You can not set both a \'currencyCode\' and a \'numberStyle\'. Please set only one of the 2.');

        $field = new NumberField('some_key', 123);
        $field->setNumberStyle(NumberStyle::decimal);
        $field->setCurrencyCode('EUR');
    }

    /**
     * @dataProvider getNumeric
     *
     * @param mixed $type
     */
    public function testAcceptsNumericTypes($type): void
    {
        $field = new NumberField('some_key', $type);

        $expected = [
            'key' => 'some_key',
            'value' => $type
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    /**
     * @dataProvider getNonNumeric
     *
     * @param mixed $type
     */
    public function testDoesNotAcceptNonNumericTypes($type): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value should be numeric.');

        $field = new NumberField('some_key');
        $field->setValue($type);
    }

    /**
     * @return array<string, mixed>
     */
    public function getNumeric(): array
    {
        return [
            'string: int' => ['123'],
            'string: float' => ['123.456'],
            'int' => [123],
            'float' => [123.456],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getNonNumeric(): array
    {
        return [
            'string' => ['some string'],
            'boolean: true' => [true],
            'boolean: false' => [false],
            'null' => [null],
            'array' => [[]],
            'class' => [new stdClass()],
        ];
    }
}
