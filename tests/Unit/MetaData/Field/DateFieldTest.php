<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\Field;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\MetaData\Field\DateField;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use LauLamanApps\ApplePassbook\Style\DateStyle;
use LauLamanApps\ApplePassbook\Style\TextAlignment;
use PHPUnit\Framework\TestCase;

final class DateFieldTest extends TestCase
{
    public function testSetLabel(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setLabel('Some label');

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'label' => 'Some label'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetDataDetectorTypes(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->addDataDetectorType(DataDetector::address());

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'dataDetectorTypes' => [DataDetector::address()->getValue()]
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetChangeMessage(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setChangeMessage('Gate changed to %s');

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'changeMessage' => 'Gate changed to %s'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetTextAlignment(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setTextAlignment(TextAlignment::center());

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'textAlignment' => TextAlignment::center()->getValue()
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetAttributedValue(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setAttributedValue('Some attribute value');

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'attributedValue' => 'Some attribute value'
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetDateStyle(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setDateStyle(DateStyle::full());

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'dateStyle' => DateStyle::full()->getValue()
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testSetTimeStyle(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->setTimeStyle(DateStyle::full());

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'timeStyle' => DateStyle::full()->getValue()
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testIgnoresTimeZone(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->ignoresTimeZone();

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'ignoresTimeZone' => true,
        ];

        self::assertSame($expected, $field->getMetadata());
    }

    public function testIsRelative(): void
    {
        $date = new DateTimeImmutable();
        $field = new DateField('some_key', $date);
        $field->isRelative();

        $expected = [
            'key' => 'some_key',
            'value' => $date->format(DateTimeImmutable::W3C),
            'isRelative' => true,
        ];

        self::assertSame($expected, $field->getMetadata());
    }
}
