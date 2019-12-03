<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build\Exception;

use Exception;
use LauLamanApps\ApplePassbook\Exception\PassbookException;

final class CertificateException extends Exception implements PassbookException
{
    public static function fileDoesNotExist(string $file): self
    {
        return new self(sprintf('Could not load certificate file \'%s\'.', $file));
    }

    public static function failedToReadPkcs12(string $file): self
    {
        return new self(sprintf('Unable to read the certificate store from PKCS#12 file \'%s\'.', $file));
    }
}
