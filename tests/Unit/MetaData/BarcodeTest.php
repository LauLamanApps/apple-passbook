<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData;

use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use PHPUnit\Framework\TestCase;

final class BarcodeTest extends TestCase
{
    public function testToArray(): void
    {
        $barcode = new Barcode(BarcodeFormat::code128(), '12345678');

        $expected = [
            'format' => BarcodeFormat::code128()->getValue(),
            'message' => '12345678',
            'messageEncoding' => 'iso-8859-1',
        ];

        self::assertSame($expected, $barcode->toArray());
    }

    public function testSetAltText(): void
    {
        $barcode = new Barcode(BarcodeFormat::code128(), '12345678', 'barcodeId');

        $expected = [
            'format' => BarcodeFormat::code128()->getValue(),
            'message' => '12345678',
            'messageEncoding' => 'iso-8859-1',
            'altText' => 'barcodeId',
        ];

        self::assertSame($expected, $barcode->toArray());

        $barcode->setAltText('shortCode');

        $expected = [
            'format' => BarcodeFormat::code128()->getValue(),
            'message' => '12345678',
            'messageEncoding' => 'iso-8859-1',
            'altText' => 'shortCode',
        ];

        self::assertSame($expected, $barcode->toArray());
    }

    public function testSetMessageEncoding(): void
    {
        $barcode = new Barcode(BarcodeFormat::code128(), '12345678');
        $barcode->setMessageEncoding('iso-8859-1:1987');

        $expected = [
            'format' => BarcodeFormat::code128()->getValue(),
            'message' => '12345678',
            'messageEncoding' => 'iso-8859-1:1987',
        ];

        self::assertSame($expected, $barcode->toArray());
    }
}
