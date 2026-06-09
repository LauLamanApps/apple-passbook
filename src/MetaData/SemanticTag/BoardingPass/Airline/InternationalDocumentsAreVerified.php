<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\AbstractBoolean;

class InternationalDocumentsAreVerified extends AbstractBoolean
{
    public function getKey(): string
    {
        return 'internationalDocumentsAreVerified';
    }
}
