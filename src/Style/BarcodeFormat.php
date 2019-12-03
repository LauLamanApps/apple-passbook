<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self qr()
 * @method bool isQr()
 * @method static self pdf417()
 * @method bool isPdf417()
 * @method static self aztec()
 * @method bool isAztec()
 * @method static self code128()
 * @method bool isCode128()
 */
class BarcodeFormat extends AbstractEnum
{
    private const QR = 'PKBarcodeFormatQR';
    private const PDF417 = 'PKBarcodeFormatPDF417';
    private const Aztec = 'PKBarcodeFormatAztec';
    private const Code128 = 'PKBarcodeFormatCode128';
}
