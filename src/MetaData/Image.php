<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData;

interface Image
{
    public function getPath(): string;
    public function getContents(): string;
    public function getFilename(): string;
}
