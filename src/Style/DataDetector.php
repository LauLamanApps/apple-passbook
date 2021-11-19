<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum DataDetector: string
{
    case phoneNumber = 'PKDataDetectorTypePhoneNumber';
    case link = 'PKDataDetectorTypeLink';
    case address = 'PKDataDetectorTypeAddress';
    case calendarEvent = 'PKDataDetectorTypeCalendarEvent';
}
