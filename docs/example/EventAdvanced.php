<?php

/**
 * Advanced Event Ticket Example
 *
 * Demonstrates: semantic tags, event type, action URLs, Aztec barcode, NFC,
 * expiration date, sharing prohibition, and associated store identifiers.
 */

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\CompilerFactory;
use LauLamanApps\ApplePassbook\EventTicketPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\Nfc;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\AdmissionLevel;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\AttendeeName;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventStartDateInfo;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventType;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\EventTypeEnum;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\PerformerNames;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\EventTicket\VenueEntranceGate;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seat;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seats;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

require_once '../../vendor/autoload.php';

$factory = new CompilerFactory();
$compiler = $factory->getCompiler(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');

//-- Build pass
$passbook = new EventTicketPassbook('CONCERT-2026-8842');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('LiveNation');
$passbook->setDescription('Coldplay - Music of the Spheres');
$passbook->setRelevantDate(new DateTimeImmutable('2026-09-20T20:00+02:00'));
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(25, 25, 112));

//-- New base properties
$passbook->setExpirationDate(new DateTimeImmutable('2026-09-21T02:00+02:00'));
$passbook->prohibitSharing();
$passbook->addAssociatedStoreIdentifier(123456789);
$passbook->setGroupingIdentifier('coldplay-amsterdam-2026');
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(52.3140, 4.9413)); // Johan Cruijff ArenA

//-- Action URLs (new in 2.0)
$passbook->setDirectionsInformationURL('https://example.com/events/coldplay/directions');
$passbook->setParkingInformationURL('https://example.com/events/coldplay/parking');
$passbook->setPurchaseParkingURL('https://example.com/events/coldplay/buy-parking');
$passbook->setOrderFoodURL('https://example.com/events/coldplay/food');
$passbook->setMerchandiseURL('https://example.com/events/coldplay/merch');
$passbook->setTransferURL('https://example.com/events/coldplay/transfer');
$passbook->setContactVenueWebsite('https://johancruijffarena.nl');
$passbook->setContactVenuePhoneNumber('+31-20-3111333');

//-- Aztec barcode
$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::Aztec);
$barcode->setMessage('CONCERT-2026-8842-SEC108-ROW12-SEAT5');
$passbook->setBarcode($barcode);

//-- NFC for contactless entry
$nfc = new Nfc('<EncryptionPublicKey>', 'CONCERT-2026-8842');
$nfc->requireAuthentication();
$passbook->setNfc($nfc);

//-- Fields with semantic tags
$event = new Field();
$event->setKey('event');
$event->setLabel('EVENT');
$event->setValue('Coldplay');
$event->addSemanticTag(new EventType(EventTypeEnum::LivePerformance));
$performers = new PerformerNames('Coldplay');
$event->addSemanticTag($performers);
$passbook->addPrimaryField($event);

$eventDate = new Field();
$eventDate->setKey('date');
$eventDate->setLabel('DATE');
$eventDate->setValue('Sep 20, 2026 — 8:00 PM');
$eventStart = new EventStartDateInfo(new DateTimeImmutable('2026-09-20T20:00+02:00'));
$eventStart->setTimeZone('Europe/Amsterdam');
$eventDate->addSemanticTag($eventStart);
$passbook->addSecondaryField($eventDate);

$venue = new Field();
$venue->setKey('venue');
$venue->setLabel('VENUE');
$venue->setValue('Johan Cruijff ArenA');
$passbook->addSecondaryField($venue);

$section = new Field();
$section->setKey('section');
$section->setLabel('SECTION');
$section->setValue('108');
$section->addSemanticTag(new Seats(new Seat(number: '5', row: '12', section: '108')));
$passbook->addAuxiliaryField($section);

$row = new Field();
$row->setKey('row');
$row->setLabel('ROW');
$row->setValue('12');
$passbook->addAuxiliaryField($row);

$seat = new Field();
$seat->setKey('seat');
$seat->setLabel('SEAT');
$seat->setValue('5');
$seat->addSemanticTag(new VenueEntranceGate('Gate C'));
$passbook->addAuxiliaryField($seat);

$level = new Field();
$level->setKey('level');
$level->setLabel('LEVEL');
$level->setValue('VIP');
$level->addSemanticTag(new AdmissionLevel('VIP'));
$passbook->addAuxiliaryField($level);

$attendee = new Field();
$attendee->setKey('attendee');
$attendee->setLabel('ATTENDEE');
$attendee->setValue('John Appleseed');
$attendee->addSemanticTag(new AttendeeName('John Appleseed'));
$passbook->addBackField($attendee);

$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/logo@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/background.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/background@2x.png'));

//-- Send data to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="event-advanced.pkpass"');

echo $compiler->compile($passbook);
