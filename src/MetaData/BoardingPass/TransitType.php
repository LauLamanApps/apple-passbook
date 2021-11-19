<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\BoardingPass;

enum TransitType: string
{
    case generic = 'PKTransitTypeGeneric';
    case air = 'PKTransitTypeAir';
    case boat = 'PKTransitTypeBoat';
    case bus = 'PKTransitTypeBus';
    case train = 'PKTransitTypeTrain';
}
