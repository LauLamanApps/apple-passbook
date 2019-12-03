<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style\Color\Exception;

use LauLamanApps\ApplePassbook\Exception\PassbookException;

final class OutOfRangeException extends \OutOfRangeException implements PassbookException
{
}
