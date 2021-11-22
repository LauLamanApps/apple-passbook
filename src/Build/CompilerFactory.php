<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use ZipArchive;

class CompilerFactory
{
    public function getCompiler(
        string $certificateFilePath,
        string $certificatePassword,
        string $appleWWDRCAFile = null
    ): Compiler {
        $signer = new Signer($certificateFilePath, $certificatePassword);
        if ($appleWWDRCAFile !== null) {
            $signer->setAppleWWDRCA($appleWWDRCAFile);
        }

        return new Compiler(new ManifestGenerator(), $signer, new Compressor(new ZipArchive()));
    }
}
