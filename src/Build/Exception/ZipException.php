<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build\Exception;

use Exception;
use LauLamanApps\ApplePassbook\Exception\PassbookException;

final class ZipException extends Exception implements PassbookException
{
    public static function canNotOpenZip(string $file, int $errorCode): self
    {
        return new self(sprintf('Can not open file \'%s\' with ZipArchive. Error code %s.', $file , $errorCode));
    }
}
