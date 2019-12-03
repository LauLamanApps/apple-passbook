<?php

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\EventTicketPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

require_once '../../vendor/autoload.php';

//-- Set up compiler and its dependencies
$manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__  . '/../../certificates/certificate.p12', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

//-- Build pass
$passbook = new EventTicketPassbook('nmyuxofgna');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Apple Inc.');
$passbook->setDescription('Apple Event Ticket');
$passbook->setRelevantDate(new DateTimeImmutable('2011-12-08T13:00-08:00'));
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(60, 65, 76));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(37.6189722, -122.3748889));
$passbook->addLocation(new Location(37.33182, -122.03118));

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::pdf417());
$barcode->setMessage('123456789');
$passbook->setBarcode($barcode);

$event = new Field();
$event->setKey('event');
$event->setLabel('EVENT');
$event->setValue('The Beat Goes On');
$passbook->addPrimaryField($event);

$loc = new Field();
$loc->setKey('loc');
$loc->setLabel('LOCATION');
$loc->setValue('Moscone West');
$passbook->addSecondaryField($loc);

$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/background.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/background@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/logo@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/thumbnail.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Event/thumbnail@2x.png'));

//-- Send data too the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="event.pkpass"');

echo $compiler->compile($passbook);