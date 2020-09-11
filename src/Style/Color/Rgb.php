<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style\Color;

use LauLamanApps\ApplePassbook\Style\Color;
use LauLamanApps\ApplePassbook\Style\Color\Exception\OutOfRangeException;

class Rgb implements Color
{
    private int $red = 0;
    private int $green = 0;
    private int $blue = 0;

    public function __construct(int $red = null, int $green = null, int $blue = null)
    {
        if ($red) {
            $this->setRed($red);
        }

        if ($green) {
            $this->setGreen($green);
        }

        if ($blue) {
            $this->setBlue($blue);
        }
    }

    public function setRed(int $red): void
    {
        $this->isValid($red);
        $this->red = $red;
    }

    public function setGreen(int $green): void
    {
        $this->isValid($green);
        $this->green = $green;
    }

    public function setBlue(int $blue): void
    {
        $this->isValid($blue);
        $this->blue = $blue;
    }

    public function toString(): string
    {
        return sprintf('rgb(%s, %s, %s)', $this->red, $this->green, $this->blue);
    }

    private function isValid(int $value): void
    {
        if ($value < 0 || $value > 255 ) {
            throw new OutOfRangeException('Value out of range (0-255).');
        }
    }
}
