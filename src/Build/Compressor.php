<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Passbook;
use LogicException;
use ZipArchive;

final class Compressor
{
    public const FILENAME = 'pass.pkpass';

    public function compress(Passbook $passbook, string $temporaryDirectory): void
    {
        $zip = new ZipArchive();
        if (!$zip->open($temporaryDirectory . self::FILENAME, ZipArchive::CREATE)) {
            throw new LogicException(sprintf('Could not open %s with ZipArchive extension.', self::FILENAME));
        }

        $zip->addFile($temporaryDirectory . Signer::FILENAME, Signer::FILENAME);
        $zip->addFile($temporaryDirectory . ManifestGenerator::FILENAME, ManifestGenerator::FILENAME);
        $zip->addFromString(Compiler::PASS_DATA_FILE, json_encode($passbook->getData()));

        foreach ($passbook->getImages() as $image) {
            $zip->addFile($image->getPath(), $image->getFilename());
        }

        $zip->close();
    }
}
