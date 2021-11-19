<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum NumberStyle: string
{
    case decimal = 'PKNumberStyleDecimal';
    case percent = 'PKNumberStylePercent';
    case scientific = 'PKNumberStyleScientific';
    case spellOut = 'PKNumberStyleSpellOut';
}
