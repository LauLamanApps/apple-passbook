<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style\Color;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\Color;

class Hex implements Color
{
    private string $hex;

    public function __construct(string $hex)
    {
        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
            throw new InvalidArgumentException('Please specify a valid hex. (without the #)');
        }

        $this->hex = $hex;
    }

    public function toString(): string
    {
        return sprintf('#%s', $this->hex);
    }
}
