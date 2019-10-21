<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\BoardingPass;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self generic()
 * @method bool isGeneric()
 * @method static self air()
 * @method bool isAir()
 * @method static self boat()
 * @method bool isBoat()
 * @method static self bus()
 * @method bool isBus()
 * @method static self train()
 * @method bool isTrain()
 */
final class TransitType extends AbstractEnum
{
    private const GENERIC = 'PKTransitTypeGeneric';
    private const AIR = 'PKTransitTypeAir';
    private const BOAT = 'PKTransitTypeBoat';
    private const BUS = 'PKTransitTypeBus';
    private const TRAIN = 'PKTransitTypeTrain';
}
