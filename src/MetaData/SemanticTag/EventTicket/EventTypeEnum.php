<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self Generic()
 * @method bool isGeneric()
 * @method static self LivePerformance()
 * @method bool isLivePerformance()
 * @method static self Movie()
 * @method bool isMovie()
 * @method static self Sports()
 * @method bool isSports()
 * @method static self Conference()
 * @method bool isConference()
 * @method static self Convention()
 * @method bool isConvention()
 * @method static self Workshop()
 * @method bool isWorkshop()
 * @method static self SocialGathering()
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