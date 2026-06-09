<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

enum DataDetector: string
{
    case PhoneNumber = 'PKDataDetectorTypePhoneNumber';
    case Link = 'PKDataDetectorTypeLink';
    case Address = 'PKDataDetectorTypeAddress';
    case CalendarEvent = 'PKDataDetectorTypeCalendarEvent';
}
