<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\EventTicket;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventType;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventTypeEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EventTypeTest extends TestCase
{
    #[DataProvider('getEnums')]
    public function testSemanticTag(EventTypeEnum $enum, string $expectedValue): void
    {
        $semanticTag = new EventType($enum);

        self::assertSame('eventType', $semanticTag->getKey());
        self::assertSame($expectedValue, $semanticTag->getValue());
    }

    /**
     * @return array<string, mixed>
     */
    public static function getEnums(): array
    {
        return [
            'generic' => [EventTypeEnum::Generic, 'PKEventTypeGeneric'],
            'livePerformance' => [EventTypeEnum::LivePerformance, 'PKEventTypeLivePerformance'],
            'movie' => [EventTypeEnum::Movie, 'PKEventTypeMovie'],
            'sports' => [EventTypeEnum::Sports, 'PKEventTypeSports'],
            'conference' => [EventTypeEnum::Conference, 'PKEventTypeConference'],
            'convention' => [EventTypeEnum::Convention, 'PKEventTypeConvention'],
            'workshop' => [EventTypeEnum::Workshop, 'PKEventTypeWorkshop'],
            'socialGathering' => [EventTypeEnum::SocialGathering, 'PKEventTypeSocialGathering'],
        ];
    }
}
