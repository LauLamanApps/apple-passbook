<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use PHPUnit\Framework\TestCase;

final class BarcodeFormatTest extends TestCase
{
    public function testAllCasesHaveCorrectValues(): void
    {
        self::assertSame('PKBarcodeFormatQR', BarcodeFormat::Qr->value);
        self::assertSame('PKBarcodeFormatPDF417', BarcodeFormat::Pdf417->value);
        self::assertSame('PKBarcodeFormatAztec', BarcodeFormat::Aztec->value);
        self::assertSame('PKBarcodeFormatCode128', BarcodeFormat::Code128->value);
        self::assertSame('PKBarcodeFormatCode39', BarcodeFormat::Code39->value);
        self::assertSame('PKBarcodeFormatCodabar', BarcodeFormat::Codabar->value);
        self::assertSame('PKBarcodeFormatEAN13', BarcodeFormat::Ean13->value);
        self::assertSame('PKBarcodeFormatI2of5', BarcodeFormat::I2of5->value);
    }

    public function testCaseCount(): void
    {
        self::assertCount(8, BarcodeFormat::cases());
    }
}
