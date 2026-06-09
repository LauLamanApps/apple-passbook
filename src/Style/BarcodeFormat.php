<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum BarcodeFormat: string
{
    case Qr = 'PKBarcodeFormatQR';
    case Pdf417 = 'PKBarcodeFormatPDF417';
    case Aztec = 'PKBarcodeFormatAztec';
    case Code128 = 'PKBarcodeFormatCode128';
    case Code39 = 'PKBarcodeFormatCode39';
    case Codabar = 'PKBarcodeFormatCodabar';
    case Ean13 = 'PKBarcodeFormatEAN13';
    case I2of5 = 'PKBarcodeFormatI2of5';
}
