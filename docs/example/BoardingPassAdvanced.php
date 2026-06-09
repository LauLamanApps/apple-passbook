<?php

/**
 * Advanced Boarding Pass Example
 *
 * Demonstrates: semantic tags, seat information, action URLs, QR barcode, and beacons.
 */

declare(strict_types=1);

use LauLamanApps\ApplePassbook\BoardingPassbook;
use LauLamanApps\ApplePassbook\Build\CompilerFactory;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Beacon;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\AirlineCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureAirportCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureGate;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DepartureTerminal;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\DestinationAirportCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightCode;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\Airline\FlightNumber;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\BoardingZone;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DepartureCityName;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\BoardingPass\DestinationCityName;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seat;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Seats;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use Ramsey\Uuid\Uuid;

require_once '../../vendor/autoload.php';

$factory = new CompilerFactory();
$compiler = $factory->getCompiler(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');

//-- Build pass
$passbook = new BoardingPassbook('KL1009-2026-07-15-12A');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setTransitType(TransitType::Air);
$passbook->setOrganizationName('Royal Dutch Airlines');
$passbook->setDescription('KLM Boarding Pass');
$passbook->setLogoText('KLM');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(0, 161, 228));
$passbook->setRelevantDate(new DateTimeImmutable('2026-07-15T10:30+02:00'));
$passbook->setGroupingIdentifier('KL1009-2026-07-15');
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(52.3105, 4.7683)); // Amsterdam Schiphol

//-- Action URLs (new in 2.0)
$passbook->setChangeSeatURL('https://example.com/flights/KL1009/change-seat');
$passbook->setTrackBagsURL('https://example.com/flights/KL1009/track-bags');
$passbook->setPurchaseWifiURL('https://example.com/flights/KL1009/wifi');
$passbook->setPurchaseLoungeAccessURL('https://example.com/flights/KL1009/lounge');
$passbook->setUpgradeURL('https://example.com/flights/KL1009/upgrade');

//-- QR Barcode (instead of PDF417)
$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::Qr);
$barcode->setMessage('M1APPLESEED/JOHN   KL1009 AMSJFK 0715 Y012A');
$barcode->setAltText('KL1009 - 12A');
$passbook->setBarcode($barcode);

//-- Beacon for airport gate proximity
$beacon = new Beacon(Uuid::fromString('b5b97f1c-85a0-4b3f-8a62-928dec04e44e'));
$beacon->setMajorIdentifier(1);
$beacon->setMinorIdentifier(100);
$beacon->setRelevantText('You are near Gate E7');
$passbook->addBeacon($beacon);

//-- Fields with semantic tags
$gate = new Field();
$gate->setKey('gate');
$gate->setLabel('GATE');
$gate->setValue('E7');
$gate->setChangeMessage('Gate changed to %@.');
$gate->addSemanticTag(new DepartureGate('E7'));
$gate->addSemanticTag(new DepartureTerminal('E'));
$passbook->addHeaderField($gate);

$depart = new Field();
$depart->setKey('depart');
$depart->setLabel('AMSTERDAM');
$depart->setValue('AMS');
$depart->addSemanticTag(new DepartureAirportCode('AMS'));
$depart->addSemanticTag(new DepartureCityName('Amsterdam'));
$passbook->addPrimaryField($depart);

$arrive = new Field();
$arrive->setKey('arrive');
$arrive->setLabel('NEW YORK');
$arrive->setValue('JFK');
$arrive->addSemanticTag(new DestinationAirportCode('JFK'));
$arrive->addSemanticTag(new DestinationCityName('New York'));
$passbook->addPrimaryField($arrive);

$passenger = new Field();
$passenger->setKey('passenger');
$passenger->setLabel('PASSENGER');
$passenger->setValue('John Appleseed');
$passbook->addSecondaryField($passenger);

$flight = new Field();
$flight->setKey('flight');
$flight->setLabel('FLIGHT');
$flight->setValue('KL 1009');
$flight->addSemanticTag(new AirlineCode('KL'));
$flight->addSemanticTag(new FlightCode('KL1009'));
$flight->addSemanticTag(new FlightNumber(1009));
$passbook->addAuxiliaryField($flight);

$boardingTime = new Field();
$boardingTime->setKey('boarding');
$boardingTime->setLabel('BOARDING');
$boardingTime->setValue('10:30');
$boardingTime->setChangeMessage('Boarding time changed to %@.');
$passbook->addAuxiliaryField($boardingTime);

$seat = new Field();
$seat->setKey('seat');
$seat->setLabel('SEAT');
$seat->setValue('12A');
$seat->addSemanticTag(new Seats(new Seat(number: '12A', row: '12', type: 'Window')));
$seat->addSemanticTag(new BoardingZone('2'));
$passbook->addAuxiliaryField($seat);

$class = new Field();
$class->setKey('class');
$class->setLabel('CLASS');
$class->setValue('Economy');
$passbook->addAuxiliaryField($class);

$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/logo@2x.png'));

//-- Send data to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="boardingpass-advanced.pkpass"');

echo $compiler->compile($passbook);
