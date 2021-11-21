<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit\MetaData\SemanticTag\BoardingPass;

use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\PassengerName;
use PHPUnit\Framework\TestCase;

class PassengerNameTest extends TestCase
{
    public function testGetKey(): void
    {
        $semanticTag = new PassengerName();

        self::assertSame('passengerName', $semanticTag->getKey());
    }

    public function testSetFamilyName(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setFamilyName('<name>');

        self::assertEquals(['familyName' => '<name>'], $semanticTag->getValue());
    }

    public function testSetFivenName(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setGivenName('<name>');

        self::assertEquals(['givenName' => '<name>'], $semanticTag->getValue());
    }

    public function testSetFiddleName(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setMiddleName('<name>');

        self::assertEquals(['middleName' => '<name>'], $semanticTag->getValue());
    }

    public function testSetFamePrefix(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setNamePrefix('<name>');

        self::assertEquals(['namePrefix' => '<name>'], $semanticTag->getValue());
    }

    public function testSetFameSuffix(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setNameSuffix('<name>');

        self::assertEquals(['nameSuffix' => '<name>'], $semanticTag->getValue());
    }

    public function testSetFickname(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setNickname('<name>');

        self::assertEquals(['nickname' => '<name>'], $semanticTag->getValue());
    }

    public function testSetPhoneticRepresentation(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setPhoneticRepresentation('<name>');

        self::assertEquals(['phoneticRepresentation' => '<name>'], $semanticTag->getValue());
    }

    public function testMultipleFields(): void
    {
        $semanticTag = new PassengerName();

        self::assertEquals([], $semanticTag->getValue());

        $semanticTag->setGivenName('<givenName>');

        self::assertEquals(['givenName' => '<givenName>'], $semanticTag->getValue());

        $semanticTag->setNameSuffix('<nameSuffix>');

        self::assertEquals(['givenName' => '<givenName>', 'nameSuffix' => '<nameSuffix>'], $semanticTag->getValue());

        $semanticTag->setFamilyName('<familyName>');

        self::assertEquals(['givenName' => '<givenName>', 'nameSuffix' => '<nameSuffix>', 'familyName' => '<familyName>'], $semanticTag->getValue());
    }
}
