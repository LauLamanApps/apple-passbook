<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic;

class WifiNetwork
{
    private string $ssid;
    private string $password;

    public function __construct(
        string $ssid,
        string $password
    ) {
        $this->ssid = $ssid;
        $this->password = $password;
    }

    /**
     * @return array<string, string>
     */
    public function getValue(): array
    {
        return [
            'ssid' => $this->ssid,
            'password' => $this->password,
        ];
    }
}
