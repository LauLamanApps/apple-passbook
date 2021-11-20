<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LogicException;

class Barcode
{
    public function __construct(
        private BarcodeFormat $format = BarcodeFormat::pdf417,
        private ?string $message = null,
        private string $messageEncoding = 'iso-8859-1',
        private ?string $altText = null
    ) {
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
            'format' => $this->format->value,
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
