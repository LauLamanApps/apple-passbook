<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass\Airline;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\PassengerCapabilities;
use PHPUnit\Framework\TestCase;

class PassengerCapabilitiesTest extends TestCase
{
    public function testConstructor(): void
    {
        $semanticTag = new PassengerCapabilities('PKPassengerCapabilityCarryon');

        self::assertEquals(['PKPassengerCapabilityCarryon'], $semanticTag->getValue());
    }

    public function testGetKey(): void
    {
        $semanticTag = new PassengerCapabilities();

        self::assertEquals('passengerCapabilities', $semanticTag->getKey());
    }

    public function testAdd(): void
    {
        $semanticTag = new PassengerCapabilities();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->add('PKPassengerCapabilityCarryon');
        self::assertEquals(['PKPassengerCapabilityCarryon'], $semanticTag->getValue());

        $semanticTag->add('PKPassengerCapabilityCheckedBag');
        self::assertEquals(['PKPassengerCapabilityCarryon', 'PKPassengerCapabilityCheckedBag'], $semanticTag->getValue());
    }
}
