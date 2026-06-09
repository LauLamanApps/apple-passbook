<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum NumberStyle: string
{
    case Decimal = 'PKNumberStyleDecimal';
    case Percent = 'PKNumberStylePercent';
    case Scientific = 'PKNumberStyleScientific';
    case SpellOut = 'PKNumberStyleSpellOut';
}
