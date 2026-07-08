<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Passbook;

class ManifestGenerator
{
    public const FILENAME = 'manifest.json';

    public function generate(Passbook $passbook, string $temporaryDirectory): void
    {
        $manifest = [Compiler::PASS_DATA_FILE => $this->hash(json_encode($passbook->getData(), JSON_THROW_ON_ERROR))];

        foreach ($passbook->getImages() as $file) {
            $manifest[$file->getFilename()] = $this->hash($file->getContents());
        }

        file_put_contents($temporaryDirectory . '/' . self::FILENAME, json_encode($manifest, JSON_THROW_ON_ERROR));
    }

    private function hash(string $data): string
    {
        return sha1($data);
    }
}
