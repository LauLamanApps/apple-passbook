<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventType;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventTypeEnum;
use PHPUnit\Framework\TestCase;

class EventTypeTest extends TestCase
{
    /**
     * @dataProvider getEnums
     */
    public function testSemanticTag(EventTypeEnum $enum, string $expectedValue): void
    {
        $semanticTag = new EventType($enum);

        self::assertSame('eventType', $semanticTag->getKey());
        self::assertSame($expectedValue, $semanticTag->getValue());
    }

    public function getEnums()
    {
        return [
            'generic' => [EventTypeEnum::generic(), 'PKEventTypeGeneric'],
            'livePerformance' => [EventTypeEnum::livePerformance(), 'PKEventTypeLivePerformance'],
            'movie' => [EventTypeEnum::movie(), 'PKEventTypeMovie'],
            'sports' => [EventTypeEnum::sports(), 'PKEventTypeSports'],
            'conference' => [EventTypeEnum::conference(), 'PKEventTypeConference'],
            'convention' => [EventTypeEnum::convention(), 'PKEventTypeConvention'],
            'workshop' => [EventTypeEnum::workshop(), 'PKEventTypeWorkshop'],
            'socialGathering' => [EventTypeEnum::socialGathering(), 'PKEventTypeSocialGathering'],
        ];
    }
}
