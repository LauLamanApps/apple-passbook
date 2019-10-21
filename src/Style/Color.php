<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

final class Color
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

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function toString(): string
    {
        return sprintf('rgb(%s, %s, %s)', $this->red, $this->green, $this->blue);
    }
}
