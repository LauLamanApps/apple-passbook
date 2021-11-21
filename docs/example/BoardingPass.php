<?php

declare(strict_types=1);

use LauLamanApps\ApplePassbook\BoardingPassbook;
use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\BoardingPass\TransitType;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

require_once '../../vendor/autoload.php';

//-- Set up compiler and its dependencies
$manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

//-- Build pass
$passbook = new BoardingPassbook('gT6zrHkaW');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setTransitType(TransitType::air());
$passbook->setOrganizationName('Skyport Airways');
$passbook->setDescription('Skyport Boarding Pass');
$passbook->setLogoText('Skyport Airways');
$passbook->addLocation(new Location(37.6189722, -122.3748889));
$passbook->setForegroundColor(new Rgb(22, 55, 110));
$passbook->setBackgroundColor(new Rgb(50, 91, 185));
$passbook->setRelevantDate(new DateTimeImmutable('2012-07-22T14:25-08:00'));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::pdf417());
$barcode->setMessage('SFOJFK JOHN APPLESEED LH451 2012-07-22T14:25-08:00');
$passbook->setBarcode($barcode);

$gate = new Field();
$gate->setKey('gate');
$gate->setLabel('GATE');
$gate->setValue('23');
$gate->setChangeMessage('Gate changed to %@.');
$passbook->addHeaderField($gate);

$depart = new Field();
$depart->setKey('depart');
$depart->setLabel('SAN FRANCISCO');
$depart->setValue('SFO');
$passbook->addPrimaryField($depart);

$arrive = new Field();
$arrive->setKey('arrive');
$arrive->setLabel('NEW YORK');
$arrive->setValue('JFK');
$passbook->addPrimaryField($arrive);

$passenger = new Field();
$passenger->setKey('passenger');
$passenger->setLabel('PASSENGER');
$passenger->setValue('John Appleseed');
$passbook->addSecondaryField($passenger);

$boardingTime = new Field();
$boardingTime->setKey('boardingTime');
$boardingTime->setLabel('DEPART');
$boardingTime->setValue('2:25 PM');
$boardingTime->setChangeMessage('Boarding time changed to %@.');
$passbook->addAuxiliaryField($boardingTime);

$flightNewName = new Field();
$flightNewName->setKey('flightNewName');
$flightNewName->setLabel('FLIGHT');
$flightNewName->setValue('815');
$flightNewName->setChangeMessage('Flight number changed to %@');
$passbook->addAuxiliaryField($flightNewName);

$class = new Field();
$class->setKey('class');
$class->setLabel('DESIG.');
$class->setValue('Coach');
$passbook->addAuxiliaryField($class);

$date = new Field();
$date->setKey('date');
$date->setLabel('DATE');
$date->setValue('7/22');
$passbook->addAuxiliaryField($date);

$passport = new Field();
$passport->setKey('passport');
$passport->setLabel('PASSPORT');
$passport->setValue('Canadian/Canadien');
$passbook->addBackField($passport);

$residence = new Field();
$residence->setKey('residence');
$residence->setLabel('RESIDENCE');
$residence->setValue('999 Infinite Loop, Apartment 42, Cupertino CA');
$passbook->addBackField($residence);

$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/BoardingPass/logo@2x.png'));

//-- Send data too the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="boardingpass.pkpass"');

echo $compiler->compile($passbook);
