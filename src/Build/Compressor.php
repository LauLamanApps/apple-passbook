<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\ZipException;
use LauLamanApps\ApplePassbook\Passbook;
use ZipArchive;

class Compressor
{
    public const FILENAME = 'pass.pkpass';

    /**
     * @var ZipArchive
     */
    private $zipArchive;

    public function __construct(ZipArchive $zipArchive)
    {
        $this->zipArchive = $zipArchive;
    }

    /**
     * @throws ZipException
     */
    public function compress(Passbook $passbook, string $temporaryDirectory): void
    {
        $file = $temporaryDirectory . self::FILENAME;

        if (($errorCode = $this->zipArchive->open($file, ZipArchive::CREATE)) !== true) {
            throw ZipException::canNotOpenZip($file, $errorCode);
        }

        $this->zipArchive->addFile($temporaryDirectory . Signer::FILENAME, Signer::FILENAME);
        $this->zipArchive->addFile($temporaryDirectory . ManifestGenerator::FILENAME, ManifestGenerator::FILENAME);
        $this->zipArchive->addFromString(Compiler::PASS_DATA_FILE, json_encode($passbook->getData()));

        foreach ($passbook->getImages() as $image) {
            $this->zipArchive->addFile($image->getPath(), $image->getFilename());
        }

        $this->zipArchive->close();
    }
}
