<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Exception;

use Exception;

final class MissingRequiredDataException extends Exception implements PassbookException
{
}
