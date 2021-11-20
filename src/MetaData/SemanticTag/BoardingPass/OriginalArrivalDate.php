<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractDate;

class OriginalArrivalDate extends AbstractDate
{
    public function getKey(): string
    {
        return 'originalArrivalDate';
    }
}
