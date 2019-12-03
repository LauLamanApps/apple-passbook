<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Style\Color;

use LauLamanApps\ApplePassbook\Exception\InvalidArgumentException;
use LauLamanApps\ApplePassbook\Style\Color\Hex;
use PHPUnit\Framework\TestCase;

final class HexTest extends TestCase
{
    public function testCanInitializeClass(): void
    {
        $color = new Hex('000000');

        $this->assertSame('#000000', $color->toString());
    }

    public function testToLongThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Please specify a valid hex. (without the #)');

        new Hex('#GH7856');
    }

    public function testToShortThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Please specify a valid hex. (without the #)');

        new Hex('GH785');
    }

    public function testSetRedNonHexThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('GH is not a valid hex code for red.');

        new Hex('GH7856');
    }

    public function testSetGreenNonHexThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('IJ is not a valid hex code for green.');

        new Hex('00IJ00');
    }

    public function testSetBlueNonHexThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('YZ is not a valid hex code for blue.');

        new Hex('0000YZ');
    }
}
