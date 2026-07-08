<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Tests\Unit;

use DateTimeImmutable;
use LauLamanApps\ApplePassbook\GenericPassbook;
use LauLamanApps\ApplePassbook\MetaData\RelevantDate;
use LauLamanApps\ApplePassbook\MetaData\UpcomingPassInformationEntry;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use PHPUnit\Framework\TestCase;

final class PassbookNewPropertiesTest extends TestCase
{
    private const UUID = 'fd39b6b4-7181-4253-969e-5df02687c617';

    public function testEventLogoText(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('eventLogoText', $data);

        $passbook->setEventLogoText('My Event');

        $data = $passbook->getData();
        self::assertArrayHasKey('eventLogoText', $data);
        self::assertSame('My Event', $data['eventLogoText']);
    }

    public function testFooterBackgroundColor(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('footerBackgroundColor', $data);

        $passbook->setFooterBackgroundColor(new Rgb(100, 100, 100));

        $data = $passbook->getData();
        self::assertArrayHasKey('footerBackgroundColor', $data);
        self::assertSame('rgb(100, 100, 100)', $data['footerBackgroundColor']);
    }

    public function testSuppressHeaderDarkening(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('suppressHeaderDarkening', $data);

        $passbook->suppressHeaderDarkening();

        $data = $passbook->getData();
        self::assertArrayHasKey('suppressHeaderDarkening', $data);
        self::assertTrue($data['suppressHeaderDarkening']);
    }

    public function testUseAutomaticColors(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('useAutomaticColors', $data);

        $passbook->useAutomaticColors();

        $data = $passbook->getData();
        self::assertArrayHasKey('useAutomaticColors', $data);
        self::assertTrue($data['useAutomaticColors']);
    }

    public function testPreferredStyleSchemes(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('preferredStyleSchemes', $data);

        $passbook->addPreferredStyleScheme('eventTicket');

        $data = $passbook->getData();
        self::assertArrayHasKey('preferredStyleSchemes', $data);
        self::assertSame(['eventTicket'], $data['preferredStyleSchemes']);
    }

    public function testAuxiliaryStoreIdentifiers(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('auxiliaryStoreIdentifiers', $data);

        $passbook->addAuxiliaryStoreIdentifier(123456);

        $data = $passbook->getData();
        self::assertArrayHasKey('auxiliaryStoreIdentifiers', $data);
        self::assertSame([123456], $data['auxiliaryStoreIdentifiers']);
    }

    public function testRelevantDates(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('relevantDates', $data);

        $passbook->addRelevantDate(RelevantDate::forDate(new DateTimeImmutable('2026-07-07T20:00:00+02:00')));
        $passbook->addRelevantDate(RelevantDate::forInterval(
            new DateTimeImmutable('2026-08-01T18:00:00+02:00'),
            new DateTimeImmutable('2026-08-01T23:00:00+02:00')
        ));

        $data = $passbook->getData();
        self::assertArrayHasKey('relevantDates', $data);
        self::assertSame(
            [
                ['date' => '2026-07-07T20:00:00+02:00'],
                ['startDate' => '2026-08-01T18:00:00+02:00', 'endDate' => '2026-08-01T23:00:00+02:00'],
            ],
            $data['relevantDates']
        );
    }

    public function testSuppressStripShine(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('suppressStripShine', $data);

        $passbook->suppressStripShine();

        $data = $passbook->getData();
        self::assertTrue($data['suppressStripShine']);

        $passbook->suppressStripShine(false);

        $data = $passbook->getData();
        self::assertFalse($data['suppressStripShine']);
    }

    public function testUpcomingPassInformation(): void
    {
        $passbook = $this->getValidPassbook();

        $data = $passbook->getData();
        self::assertArrayNotHasKey('upcomingPassInformation', $data);

        $passbook->addUpcomingPassInformation(new UpcomingPassInformationEntry('event-123', 'Summer Concert'));

        $data = $passbook->getData();
        self::assertArrayHasKey('upcomingPassInformation', $data);
        self::assertSame(
            [
                [
                    'identifier' => 'event-123',
                    'name' => 'Summer Concert',
                    'type' => 'event',
                ],
            ],
            $data['upcomingPassInformation']
        );
    }

    private function getValidPassbook(): GenericPassbook
    {
        $passbook = new GenericPassbook(self::UUID);
        $passbook->setPassTypeIdentifier('pass.com.anonymous');
        $passbook->setTeamIdentifier('9X3HHK8VXA');
        $passbook->setOrganizationName('LauLaman Apps');
        $passbook->setDescription('Pass for LauLaman Apps');

        return $passbook;
    }
}
