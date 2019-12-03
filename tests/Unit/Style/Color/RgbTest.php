<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Style\Color;

use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

final class RgbTest extends TestCase
{
    public function testCanInitializeClass(): void
    {
        $color = new Rgb();

        $this->assertSame('rgb(0, 0, 0)', $color->toString());
    }

    public function testConstructorArguments(): void
    {
        $color = new Rgb(12, 34, 56);

        $this->assertSame('rgb(12, 34, 56)', $color->toString());
    }

    public function testSetRed(): void
    {
        $color = new Rgb();
        $color->setRed(127);

        $this->assertSame('rgb(127, 0, 0)', $color->toString());
    }

    public function testSetGreen(): void
    {
        $color = new Rgb();
        $color->setGreen(127);

        $this->assertSame('rgb(0, 127, 0)', $color->toString());
    }

    public function testSetBlue(): void
    {
        $color = new Rgb();
        $color->setBlue(127);

        $this->assertSame('rgb(0, 0, 127)', $color->toString());
    }

    public function testValidRange(): void
    {
        $color = new Rgb();

        for ($n = 0; $n <= 255; $n++) {
            $color->setRed($n);
            $color->setGreen($n);
            $color->setBlue($n);
            $this->assertSame(sprintf('rgb(%s, %s, %s)', $n, $n, $n), $color->toString());
        }
    }

    public function testSetRedBelowRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setRed(-1);
    }

    public function testSetGreenBelowRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setGreen(-1);
    }

    public function testSetBlueBelowRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setBlue(-1);
    }

    public function testSetRedAboveRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setRed(256);
    }

    public function testSetGreenAboveRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setGreen(256);
    }

    public function testSetBlueAboveRangeThrowsOutOfRangeException(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage('Value out of range (0-255).');

        $color = new Rgb();
        $color->setBlue(256);
    }
}
