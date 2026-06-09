<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\BoardingPass;

enum TransitType: string
{
    case Generic = 'PKTransitTypeGeneric';
    case Air = 'PKTransitTypeAir';
    case Boat = 'PKTransitTypeBoat';
    case Bus = 'PKTransitTypeBus';
    case Train = 'PKTransitTypeTrain';
}
