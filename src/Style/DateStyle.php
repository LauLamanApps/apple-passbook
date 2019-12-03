<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self none()
 * @method bool isNone()
 * @method static self short()
 * @method bool isShort()
 * @method static self medium()
 * @method bool isMedium()
 * @method static self long()
 * @method bool isLong()
 * @method static self full()
 * @method bool isFull()
 */
class DateStyle extends AbstractEnum
{
    private const NONE ='PKDateStyleNone';
    private const SHORT ='PKDateStyleShort';
    private const MEDIUM ='PKDateStyleMedium';
    private const LONG ='PKDateStyleLong';
    private const FULL ='PKDateStyleFull';
}
