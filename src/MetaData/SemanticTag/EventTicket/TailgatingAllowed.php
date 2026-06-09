<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractBoolean;

class TailgatingAllowed extends AbstractBoolean
{
    public function getKey(): string
    {
        return 'tailgatingAllowed';
    }
}
