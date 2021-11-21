<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self generic()
 * @method bool isGeneric()
 * @method static self livePerformance()
 * @method bool isLivePerformance()
 * @method static self movie()
 * @method bool isMovie()
 * @method static self sports()
 * @method bool isSports()
 * @method static self conference()
 * @method bool isConference()
 * @method static self convention()
 * @method bool isConvention()
 * @method static self workshop()
 * @method bool isWorkshop()
 * @method static self socialGathering()
 * @method bool isSocialGathering()
 */
class EventTypeEnum extends AbstractEnum
{
    private const GENERIC = 'PKEventTypeGeneric';
    private const LIVE_PERFORMANCE = 'PKEventTypeLivePerformance';
    private const MOVIE = 'PKEventTypeMovie';
    private const SPORTS = 'PKEventTypeSports';
    private const CONFERENCE = 'PKEventTypeConference';
    private const CONVENTION = 'PKEventTypeConvention';
    private const WORKSHOP = 'PKEventTypeWorkshop';
    private const SOCIAL_GATHERING = 'PKEventTypeSocialGathering';
}
