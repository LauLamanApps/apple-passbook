<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Passbook;

final class ManifestGenerator
{
    public const FILENAME = 'manifest.json';

    public function generate(Passbook $passbook, string $temporaryDirectory): void
    {
        $manifest = [Compiler::PASS_DATA_FILE => $this->hash(json_encode($passbook->getData()))];

        foreach ($passbook->getImages() as $file) {
            $manifest[$file->getFilename()] = $this->hash(file_get_contents($file->getPath()));
        }

        file_put_contents($temporaryDirectory . self::FILENAME, json_encode($manifest));
    }

    private function hash($data): string
    {
        return sha1($data);
    }
}
