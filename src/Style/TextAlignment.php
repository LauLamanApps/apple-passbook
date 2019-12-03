<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self left()
 * @method bool isLeft()
 * @method static self center()
 * @method bool isCenter()
 * @method static self right()
 * @method bool isRight()
 * @method static self natural()
 * @method bool isNatural()
 */
class TextAlignment extends AbstractEnum
{
    private const LEFT = 'PKTextAlignmentLeft';
    private const CENTER = 'PKTextAlignmentCenter';
    private const RIGHT = 'PKTextAlignmentRight';
    private const NATURAL = 'PKTextAlignmentNatural';
}
