<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use LauLamanApps\ApplePassbook\Style\BarcodeFormat;

class Barcode
{
    /**
     * @var string
     */
    private $altText;

    /**
     * @var BarcodeFormat
     */
    private $format;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $messageEncoding = 'iso-8859-1';

    public function __construct(?BarcodeFormat $format = null, ?string $message = null, ?string $altText = null)
    {
        $this->format = $format;
        $this->message = $message;
        $this->altText = $altText;
    }

    public function setFormat(BarcodeFormat $format): void
    {
        $this->format = $format;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setAltText(string $altText): void
    {
        $this->altText = $altText;
    }

    public function setMessageEncoding(string $messageEncoding): void
    {
        $this->messageEncoding = $messageEncoding;
    }

    public function toArray(): array
    {
        $data = [
            'format' => $this->format->getValue(),
            'message' => $this->message,
            'messageEncoding' => $this->messageEncoding,
        ];

        if ($this->altText) {
            $data['altText'] = $this->altText;
        }

        return $data;
    }
}
