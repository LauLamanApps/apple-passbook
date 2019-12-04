<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\Exception\ZipException;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\MetaData\Image;
use LauLamanApps\ApplePassbook\Passbook;
use PHPUnit\Framework\TestCase;
use ZipArchive;

/**
 * @coversDefaultClass \LauLamanApps\ApplePassbook\Build\Compressor
 */
final class CompressorTest extends TestCase
{
    /**
     * @covers \LauLamanApps\ApplePassbook\Build\Compressor::compress
     */
    public function testCompress(): void
    {
        $tempDir = '/tmp/passbook/';

        $image = $this->createMock(Image::class);
        $image->expects($this->once())->method('getPath')->willReturn('/path/to/image.png');
        $image->expects($this->once())->method('getFilename')->willReturn('icon.png');

        $passbook = $this->createMock(Passbook::class);
        $passbook->expects($this->once())->method('getData')->willReturn(['<passbook_data>']);
        $passbook->expects($this->once())->method('getImages')->willReturn([$image]);

        $zipArchive = $this->createMock(ZipArchive::class);
        $zipArchive->expects($this->once())->method('open')->willReturn(true);
        $zipArchive->expects($this->once())->method('close');
        $zipArchive->expects($this->exactly(3))->method('addFile')->withConsecutive(
            [$tempDir . Signer::FILENAME, Signer::FILENAME],
            [$tempDir . ManifestGenerator::FILENAME, ManifestGenerator::FILENAME],
            ['/path/to/image.png', 'icon.png']
        );
        $zipArchive->expects($this->once())->method('addFromString')->with(Compiler::PASS_DATA_FILE, '["<passbook_data>"]');

        $generator = new Compressor($zipArchive);
        $generator->compress($passbook, $tempDir);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Build\Compressor::compress
     */
    public function testCantOpenZipArchiveThrowsException(): void
    {
        $this->expectException(ZipException::class);
        $this->expectExceptionMessage('Can not open file \'/tmp/passbook/pass.pkpass\' with ZipArchive. Error code 19.');

        $tempDir = '/tmp/passbook/';
        $passbook = $this->createMock(Passbook::class);
        $zipArchive = $this->createMock(ZipArchive::class);
        $zipArchive->expects($this->once())->method('open')->willReturn(ZipArchive::ER_NOZIP);

        $generator = new Compressor($zipArchive);
        $generator->compress($passbook, $tempDir);

    }
}
