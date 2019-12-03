<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self decimal()
 * @method bool isDecimal()
 * @method static self percent()
 * @method bool isPercent()
 * @method static self scientific()
 * @method bool isScientific()
 * @method static self spellOut()
 * @method bool isSpellOut()
 */
class NumberStyle extends AbstractEnum
{
    private const DECIMAL = 'PKNumberStyleDecimal';
    private const PERCENT = 'PKNumberStylePercent';
    private const SCIENTIFIC = 'PKNumberStyleScientific';
    private const SPELL_OUT = 'PKNumberStyleSpellOut';
}
