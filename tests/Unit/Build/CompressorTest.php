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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ZipArchive;

#[CoversClass(Compressor::class)]
#[CoversClass(ZipException::class)]
final class CompressorTest extends TestCase
{
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
        $expectedCalls = [
            [$tempDir . Signer::FILENAME, Signer::FILENAME],
            [$tempDir . ManifestGenerator::FILENAME, ManifestGenerator::FILENAME],
            ['/path/to/image.png', 'icon.png'],
        ];
        $callIndex = 0;
        $zipArchive->expects($this->exactly(3))->method('addFile')->willReturnCallback(
            function (string $path, string $name) use (&$callIndex, $expectedCalls): bool {
                [$expectedPath, $expectedName] = $expectedCalls[$callIndex++];
                $this->assertSame($expectedPath, $path);
                $this->assertSame($expectedName, $name);
                return true;
            }
        );
        $zipArchive->expects($this->once())->method('addFromString')->with(Compiler::PASS_DATA_FILE, '["<passbook_data>"]');

        $generator = new Compressor($zipArchive);
        $generator->compress($passbook, $tempDir);
    }

    public function testImageFilenameWithDirectoryPartsThrowsException(): void
    {
        $this->expectException(ZipException::class);
        $this->expectExceptionMessage('Image filename \'../evil.png\' is not allowed in a pass archive.');

        $this->compressWithImageFilename('../evil.png');
    }

    public function testImageFilenameCollidingWithReservedNameThrowsException(): void
    {
        $this->expectException(ZipException::class);
        $this->expectExceptionMessage('Image filename \'manifest.json\' is not allowed in a pass archive.');

        $this->compressWithImageFilename('manifest.json');
    }

    private function compressWithImageFilename(string $filename): void
    {
        $image = $this->createMock(Image::class);
        $image->method('getPath')->willReturn('/path/to/image.png');
        $image->method('getFilename')->willReturn($filename);

        $passbook = $this->createMock(Passbook::class);
        $passbook->method('getData')->willReturn(['<passbook_data>']);
        $passbook->method('getImages')->willReturn([$image]);

        $zipArchive = $this->createMock(ZipArchive::class);
        $zipArchive->method('open')->willReturn(true);

        $compressor = new Compressor($zipArchive);
        $compressor->compress($passbook, '/tmp/passbook/');
    }

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
