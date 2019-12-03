<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style\Color;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\Color;

class Hex implements Color
{
    /**
     * @var int
     */
    private $red;

    /**
     * @var int
     */
    private $green;

    /**
     * @var int
     */
    private $blue;

    public function __construct(string $hex)
    {
        if (strlen($hex) !== 6) {
            throw new InvalidArgumentException('Please specify a valid hex. (without the #)');
        }

        if (($this->red = @hex2bin(substr($hex, 0, 2)))  === false) {
            throw new InvalidArgumentException(sprintf('%s is not a valid hex code for red.', substr($hex, 0, 2)));
        }

        if (($this->green = @hex2bin(substr($hex, 2, 2))) === false) {
            throw new InvalidArgumentException(sprintf('%s is not a valid hex code for green.', substr($hex, 2, 2)));
        }

        if (($this->blue = @hex2bin(substr($hex, 4, 2))) === false) {
            throw new InvalidArgumentException(sprintf('%s is not a valid hex code for blue.', substr($hex, 4, 2)));
        }
    }

    public function toString(): string
    {
        return sprintf('#%s%s%s', bin2hex($this->red), bin2hex($this->green), bin2hex($this->blue));
    }
}
