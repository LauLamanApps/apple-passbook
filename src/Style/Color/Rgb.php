<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style\Color;

use LauLamanApps\ApplePassbook\Style\Color;
use LauLamanApps\ApplePassbook\Style\Color\Exception\OutOfRangeException;

class Rgb implements Color
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

    public function __construct(?int $red = 0, ?int $green = 0, ?int $blue = 0)
    {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    public function setRed(int $red): void
    {
        $this->isValidValue($red);
        $this->red = $red;
    }

    public function setGreen(int $green): void
    {
        $this->isValidValue($green);
        $this->green = $green;
    }

    public function setBlue(int $blue): void
    {
        $this->isValidValue($blue);
        $this->blue = $blue;
    }

    public function toString(): string
    {
        return sprintf('rgb(%s, %s, %s)', $this->red, $this->green, $this->blue);
    }

    private function isValidValue(int $value): void
    {
        if ($value < 0) {
            $this->throwInvalidArgumentException();
        }

        if ($value > 255) {
            $this->throwInvalidArgumentException();
        }
    }

    private function throwInvalidArgumentException()
    {
        throw new OutOfRangeException('Value out of range (0-255).');
    }
}
