<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Style;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self phoneNumber()
 * @method bool isPhoneNumber()
 * @method static self link()
 * @method bool isLink()
 * @method static self address()
 * @method bool isAddress()
 * @method static self calendarEvent()
 * @method bool isCalendarEvent()
 */
final class DataDetector extends AbstractEnum
{
    private const PHONE_NUMBER = 'PKDataDetectorTypePhoneNumber';
    private const LINK = 'PKDataDetectorTypeLink';
    private const ADDRESS = 'PKDataDetectorTypeAddress';
    private const CALENDAR_EVENT = 'PKDataDetectorTypeCalendarEvent';
}
