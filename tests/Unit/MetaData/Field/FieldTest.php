<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\Field;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightNumber;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiAccess;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiNetwork;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

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
        $field->addDataDetectorType(DataDetector::address);

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'dataDetectorTypes' => [DataDetector::address->value]
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
        $field->setTextAlignment(TextAlignment::center);

        $expected = [
            'key' => 'some_key',
            'value' => 'Some value',
            'textAlignment' => TextAlignment::center->value
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
     *
     * @param mixed $type
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
     *
     * @param mixed $type
     */
    public function testDoesNotAcceptNonScalarTypes($type): void
    {
        $this->expectException(TypeError::class);

        $field = new Field();
        $field->setValue($type);
    }

    public function testAddSemanticTag(): void
    {
        $field = new Field('some_key', 'Some value');

        $data = $field->getMetadata();
        self::assertArrayNotHasKey('semantics', $data);

        $semanticTagMock1 = $this->createMock(SemanticTag::class);
        $semanticTagMock1->expects($this->once())->method('getKey')->willReturn('<SemanticTag1Key>');
        $semanticTagMock1->expects($this->once())->method('getValue')->willReturn('<SemanticTag1Value>');
        $semanticTagMock2 = $this->createMock(SemanticTag::class);
        $semanticTagMock2->expects($this->once())->method('getKey')->willReturn('<SemanticTag2Key>');
        $semanticTagMock2->expects($this->once())->method('getValue')->willReturn('<SemanticTag2Value>');
        $semanticTagMock3 = $this->createMock(SemanticTag::class);
        $semanticTagMock3->expects($this->once())->method('getKey')->willReturn('<SemanticTag3Key>');
        $semanticTagMock3->expects($this->once())->method('getValue')->willReturn('<SemanticTag3Value>');

        $field->addSemanticTag($semanticTagMock1);
        $field->addSemanticTag($semanticTagMock2);
        $field->addSemanticTag($semanticTagMock3);

        $data = $field->getMetadata();
        self::assertArrayHasKey('semantics', $data);

        $expected = [
            '<SemanticTag1Key>' => '<SemanticTag1Value>',
            '<SemanticTag2Key>' => '<SemanticTag2Value>',
            '<SemanticTag3Key>' => '<SemanticTag3Value>',
        ];
        self::assertEquals($expected, $data['semantics']);
    }

    /**
     * @return array<string, mixed>
     */
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

    /**
     * @return array<string, mixed>
     */
    public function getNonScalars(): array
    {
        return [
            'null' => [null],
            'array' => [[]],
            'class' => [new stdClass()],
        ];
    }
}
