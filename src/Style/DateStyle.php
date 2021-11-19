<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum DateStyle: string
{
    case none = 'PKDateStyleNone';
    case short = 'PKDateStyleShort';
    case medium = 'PKDateStyleMedium';
    case long = 'PKDateStyleLong';
    case full = 'PKDateStyleFull';
}
