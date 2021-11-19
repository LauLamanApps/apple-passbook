<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum BarcodeFormat: string
{
    case qr = 'PKBarcodeFormatQR';
    case pdf417 = 'PKBarcodeFormatPDF417';
    case aztec = 'PKBarcodeFormatAztec';
    case code128 = 'PKBarcodeFormatCode128';
}
