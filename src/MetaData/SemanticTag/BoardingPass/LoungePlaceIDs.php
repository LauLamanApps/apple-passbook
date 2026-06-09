<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractStringArray;

class LoungePlaceIDs extends AbstractStringArray
{
    public function getKey(): string
    {
        return 'loungePlaceIDs';
    }
}
