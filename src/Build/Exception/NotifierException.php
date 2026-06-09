<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build\Exception;

use Exception;
use LauLamanApps\ApplePassbook\Exception\PassbookException;

final class NotifierException extends Exception implements PassbookException
{
    public static function connectionFailed(string $reason): self
    {
        return new self(sprintf('Failed to connect to APNs: %s', $reason));
    }

    public static function rejected(int $httpStatusCode, string $reason): self
    {
        return new self(sprintf('APNs rejected the notification (HTTP %d): %s', $httpStatusCode, $reason));
    }

    public static function missingCurl(): self
    {
        return new self('The cURL extension with HTTP/2 support is required to send push notifications.');
    }
}
