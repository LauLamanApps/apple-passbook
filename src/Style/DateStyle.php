<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum DateStyle: string
{
    case None = 'PKDateStyleNone';
    case Short = 'PKDateStyleShort';
    case Medium = 'PKDateStyleMedium';
    case Long = 'PKDateStyleLong';
    case Full = 'PKDateStyleFull';
}
