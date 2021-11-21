<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LogicException;

class Barcode
{
    private string $altText;
    private BarcodeFormat $format;
    private string $message;
    private string $messageEncoding = 'iso-8859-1';

    public function __construct(?BarcodeFormat $format = null, ?string $message = null, ?string $altText = null)
    {
        $this->format = $format ?? BarcodeFormat::pdf417();

        if ($message) {
            $this->message = $message;
        }

        if ($altText) {
            $this->altText = $altText;
        }
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

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        $this->validate();

        $data = [
            'format' => (string) $this->format->getValue(),
            'message' => $this->message,
            'messageEncoding' => $this->messageEncoding,
        ];

        if (isset($this->altText)) {
            $data['altText'] = $this->altText;
        }

        return $data;
    }

    private function validate(): void
    {
        if (!isset($this->message)) {
            throw new LogicException('no message specified');
        }
    }
}
