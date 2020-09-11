<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\ZipException;
use LauLamanApps\ApplePassbook\Exception\MissingRequiredDataException;
use LauLamanApps\ApplePassbook\Passbook;
use Ramsey\Uuid\Uuid;

class Compiler
{
    public const PASS_DATA_FILE = 'pass.json';

    private ManifestGenerator $manifestGenerator;
    private Signer $signer;
    private Compressor $compressor;
    private string $passTypeIdentifier;
    private string $teamIdentifier;

    public function __construct(
        ManifestGenerator $manifestGenerator,
        Signer $signer,
        Compressor $compressor,
        ?string $passTypeIdentifier = null,
        ?string $teamIdentifier = null
    ) {
        $this->manifestGenerator = $manifestGenerator;
        $this->signer = $signer;
        $this->compressor = $compressor;

        if ($passTypeIdentifier) {
            $this->passTypeIdentifier = $passTypeIdentifier;
        }

        if ($teamIdentifier) {
            $this->teamIdentifier = $teamIdentifier;
        }
    }

    public function setPassTypeIdentifier(string $passTypeIdentifier): void
    {
        $this->passTypeIdentifier = $passTypeIdentifier;
    }

    public function setTeamIdentifier(string $teamIdentifier): void
    {
        $this->teamIdentifier = $teamIdentifier;
    }

    /**
     * @throws MissingRequiredDataException
     * @throws ZipException
     */
    public function compile(Passbook $passbook): string
    {
        $this->validate($passbook);

        if (!$passbook->hasPassTypeIdentifier() && isset($this->passTypeIdentifier)) {
            $passbook->setPassTypeIdentifier($this->passTypeIdentifier);
        }

        if (!$passbook->hasTeamIdentifier() && isset($this->teamIdentifier)) {
            $passbook->setTeamIdentifier($this->teamIdentifier);
        }

        $temporaryDirectory = $this->createTemporaryDirectory();

        try {
            $this->manifestGenerator->generate($passbook, $temporaryDirectory);
            $this->signer->sign($temporaryDirectory);
            $this->compressor->compress($passbook, $temporaryDirectory);

            return (string) file_get_contents($temporaryDirectory . Compressor::FILENAME);
        } finally {
            $this->cleanup($temporaryDirectory);
        }
    }

    /**
     * @throws MissingRequiredDataException
     */
    private function validate(Passbook $passbook): void
    {
        if (isset($this->passTypeIdentifier) && $passbook->hasPassTypeIdentifier() === false) {
            throw new MissingRequiredDataException('PassTypeIdentifier is unknown. Either specify it on the passbook and/or specify it in the compiler.');
        }

        if (isset($this->teamIdentifier) && $passbook->hasTeamIdentifier() === false) {
            throw new MissingRequiredDataException('TeamIdentifier is unknown. Either specify it on the passbook and/or specify it in the compiler.');
        }
    }

    private function createTemporaryDirectory(): string
    {
        $dir = sprintf('%s/passbook_%s/', sys_get_temp_dir(), Uuid::uuid4()->toString());

        mkdir($dir);

        return $dir;
    }

    private function cleanup(string $temporaryDirectory): void
    {
        $files = array_diff((array) scandir($temporaryDirectory), ['..', '.']);
        foreach ($files as $file) {
            unlink($temporaryDirectory . $file);
        }

        rmdir($temporaryDirectory);
    }
}
