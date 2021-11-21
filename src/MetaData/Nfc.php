<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

class Nfc
{
    private string $encryptionPublicKey;
    private string $message;
    private bool $requiresAuthentication = false;

    public function __construct(string $encryptionPublicKey, string $message)
    {
        $this->encryptionPublicKey = $encryptionPublicKey;
        $this->message = $message;
    }

    public function requireAuthentication(): void
    {
        $this->requiresAuthentication = true;
    }

    public function requiresAuthentication(): bool
    {
        return $this->requiresAuthentication;
    }

    /**
     * @return array<string, string|true>
     */
    public function toArray(): array
    {
        $data = [
            'encryptionPublicKey' => $this->encryptionPublicKey,
            'message' => $this->message,
        ];

        if ($this->requiresAuthentication) {
            $data['requiresAuthentication'] = $this->requiresAuthentication;
        }

        return $data;
    }
}
