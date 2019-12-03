<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\Image;

use LauLamanApps\ApplePassbook\MetaData\Image;
use LogicException;

class LocalImage implements Image
{
    private $path;

    private $filename;

    public function __construct(string $path, ?string $filename = null)
    {
        if (!file_exists($path)) {
            throw new LogicException(sprintf('Image %s does not exist.', $path));
        }

        if (function_exists('exif_imagetype')) {
            if (exif_imagetype($path) !== IMAGETYPE_PNG) {
                throw new LogicException('Image should be of type PNG.');
            }
        }

        $this->path = $path;
        $this->filename = $filename ?? basename($path);
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getContents(): string
    {
        return file_get_contents($this->path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }
}
