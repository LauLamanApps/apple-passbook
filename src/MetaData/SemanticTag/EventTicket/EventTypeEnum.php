<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket;

enum EventTypeEnum: string
{
    case Generic = 'PKEventTypeGeneric';
    case LivePerformance = 'PKEventTypeLivePerformance';
    case Movie = 'PKEventTypeMovie';
    case Sports = 'PKEventTypeSports';
    case Conference = 'PKEventTypeConference';
    case Convention = 'PKEventTypeConvention';
    case Workshop = 'PKEventTypeWorkshop';
    case SocialGathering = 'PKEventTypeSocialGathering';
}
