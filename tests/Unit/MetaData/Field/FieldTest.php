<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use PHPUnit\Framework\TestCase;
use stdClass;

final class FieldTest extends TestCase
{
    public function testSetLabel(): void
    {
        $field = new Field('some_key', 'Some value');
        $field->setLabel('Some label');

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'label' => 'Some label'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetLabelInConstructor(): void
    {
        $field = new Field('some_key', 'Some value', 'Some label');

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'label' => 'Some label'
        ];

        self::assertSame($expected, $field->getMetadata());

        $field->setLabel('Updated Label');

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'label' => 'Updated Label'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetDataDetectorTypes(): void
    {
        $field = new Field('some_key', 'Some value');
        $field->addDataDetectorType(DataDetector::address());

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'dataDetectorTypes' => [DataDetector::address()->getValue()]
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetChangeMessage(): void
    {
        $field = new Field('some_key', 'Some value');
        $field->setChangeMessage('Gate changed to %s');

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'changeMessage' => 'Gate changed to %s'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetTextAlignment(): void
    {
        $field = new Field('some_key', 'Some value');
        $field->setTextAlignment(TextAlignment::center());

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'textAlignment' => TextAlignment::center()->getValue()
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetAttributedValue(): void
    {
        $field = new Field('some_key', 'Some value');
        $field->setAttributedValue('Some attribute value');

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'attributedValue' => 'Some attribute value'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    /**
     * @dataProvider getScalars
     */
    public function testAcceptsScalarTypes($type): void
    {
        $field = new Field('some_key', $type);

        $expected = [
            'key' => 'some_key',
            'value' => $type
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    /**
     * @dataProvider getNonScalars
     */
    public function testDoesNotAcceptNonScalarTypes($type): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value should be a scalar type.');

        $field = new Field();
        $field->setValue($type);
    }

    public function getScalars(): array
    {
        return [
            'string' => ['some string'],
            'int' => [123],
            'float' => [123.456],
            'boolean: true' => [true],
            'boolean: false' => [false],
        ];
    }

    public function getNonScalars(): array
    {
        return [
            'null' => [null],
            'array' => [[]],
            'class' => [new stdClass()],
        ];
    }
}
