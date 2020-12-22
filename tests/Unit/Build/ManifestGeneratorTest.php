<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\Build;

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\GenericPassbook;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\Passbook;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass \LauLamanApps\ApplePassbook\Build\ManifestGenerator
 */
final class ManifestGeneratorTest extends TestCase
{
    /**
     * @covers \LauLamanApps\ApplePassbook\Build\ManifestGenerator::generate
     * @covers \LauLamanApps\ApplePassbook\Build\ManifestGenerator::hash
     */
    public function testGenerate(): void
    {
        $tempDir = sys_get_temp_dir();

        $passbook = $this->createMock(Passbook::class);

        $generator = new ManifestGenerator();
        $generator->generate($passbook, $tempDir);

        $file = $tempDir . '/' . ManifestGenerator::FILENAME;

        if (!$file = file_get_contents($file)) {
            throw new \Exception('Error loading file');
        }

        $manifest = json_decode($file, true);

        self::assertSame('97d170e1550eee4afc0af065b78cda302a97674c', $manifest[Compiler::PASS_DATA_FILE]);
    }

    /**
     * @covers \LauLamanApps\ApplePassbook\Build\ManifestGenerator::generate
     * @covers \LauLamanApps\ApplePassbook\Build\ManifestGenerator::hash
     * @covers \LauLamanApps\ApplePassbook\MetaData\Image\LocalImage::__construct
     * @covers \LauLamanApps\ApplePassbook\MetaData\Image\LocalImage::getContents
     * @covers \LauLamanApps\ApplePassbook\MetaData\Image\LocalImage::getFilename
     * @covers \LauLamanApps\ApplePassbook\Passbook::__construct
     * @covers \LauLamanApps\ApplePassbook\Passbook::addImage
     * @covers \LauLamanApps\ApplePassbook\Passbook::getData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getFieldsData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getGenericData
     * @covers \LauLamanApps\ApplePassbook\Passbook::getImages
     * @covers \LauLamanApps\ApplePassbook\Passbook::setDescription
     * @covers \LauLamanApps\ApplePassbook\Passbook::setOrganizationName
     * @covers \LauLamanApps\ApplePassbook\Passbook::setPassTypeIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::setTeamIdentifier
     * @covers \LauLamanApps\ApplePassbook\Passbook::validate
     */
    public function testGenerateWithFiles(): void
    {
        $tempDir = sys_get_temp_dir();

        $image1 = new LocalImage(__DIR__ . '/../../files/MetaData/Image/valid_1px_red.png', 'icon.png');
        $image2 = new LocalImage(__DIR__ . '/../../files/MetaData/Image/valid_1px_blue.png', 'logo.png');

        $passbook = new GenericPassbook('f4217280-be57-479f-a335-58a7fe695fe7');
        $passbook->setPassTypeIdentifier('pass.com.test.laulamanapps');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('My Awesome Organization');
        $passbook->setDescription('Description for pass');
        $passbook->addImage($image1);
        $passbook->addImage($image2);

        $generator = new ManifestGenerator();
        $generator->generate($passbook, $tempDir);

        $file = $tempDir . '/' . ManifestGenerator::FILENAME;

        if (!$file = file_get_contents($file)) {
            throw new \Exception('Error loading file');
        }

        $manifest = json_decode($file, true);

        self::assertSame('6904316624dff99eeaf763eebde9d788118233e4', $manifest[Compiler::PASS_DATA_FILE]);
        self::assertSame('bd269860bb508aebcb6f08fe7289d5f117830383', $manifest['icon.png']);
        self::assertSame('34b06fb311f15ba2636319e50181bc44d81c3f93', $manifest['logo.png']);
    }
}
