<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

enum ApnsEnvironment: string
{
    case Production = 'https://api.push.apple.com';
    case Sandbox = 'https://api.sandbox.push.apple.com';
}
