<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\Image;

use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LogicException;
use PHPUnit\Framework\TestCase;

final class LocalImageTest extends TestCase
{
    private const FILE_DIR = '../../../files/MetaData/Image';

    public function testConstructWithValidImageSucceeds(): void
    {
        $filename = 'valid_1px_red.png';
        $file = $this->getFilePath($filename);

        $localImage = new LocalImage($file);

        $this->assertSame($file, $localImage->getPath());
        $this->assertSame($filename, $localImage->getFilename());
    }

    public function testsetFilename(): void
    {
        $filename = 'valid_1px_red.png';
        $file = $this->getFilePath($filename);

        $localImage = new LocalImage($file, 'icon.png');
        $this->assertSame($file, $localImage->getPath());
        $this->assertSame('icon.png', $localImage->getFilename());

        $localImage->setFilename('logo.png');

        $this->assertSame($file, $localImage->getPath());
        $this->assertSame('logo.png', $localImage->getFilename());
    }

    public function testNonExistingFileThrowsException(): void
    {
        $file = $this->getFilePath('non_existing.png');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(sprintf('Image %s does not exist.', $file));

        new LocalImage($file);
    }

    public function testWrongFileTypeThrowsException(): void
    {
        if (!function_exists('exif_imagetype')) {
            self::markTestSkipped('php extension exif_imagetype is missing.');
        }

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Image should be of type PNG.');

        new LocalImage($this->getFilePath('textfile.txt'));
    }

    private function getFilePath(string $filename): string
    {
        return sprintf('%s/%s/%s', __DIR__, self::FILE_DIR, $filename);
    }
}
