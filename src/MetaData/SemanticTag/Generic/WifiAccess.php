<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

class WifiAccess implements SemanticTag
{
    /** @var WifiNetwork[] */
    private array $wifiNetworks = [];

    public function addWifiNetwork(WifiNetwork $wifiNetwork): void
    {
        $this->wifiNetworks[] = $wifiNetwork;
    }

    public function getKey(): string
    {
        return 'wifiAccess';
    }

    public function getValue(): array
    {
        $wifiNetworks = [];

        foreach ($this->wifiNetworks as $wifiNetwork) {
            $wifiNetworks[] = $wifiNetwork->getValue();
        }

        return $wifiNetworks;
    }
}