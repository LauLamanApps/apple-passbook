<?php

/**
 * Generic NFC Pass Example
 *
 * Demonstrates: NFC-enabled generic pass for access control (e.g. employee badge,
 * gym membership, office access card). Uses NFC with authentication, Wi-Fi semantic
 * tags, data detectors, and app launch URL.
 */

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\CompilerFactory;
use LauLamanApps\ApplePassbook\GenericPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Beacon;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\Nfc;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiAccess;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\Generic\WifiNetwork;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use LauLamanApps\ApplePassbook\Style\DataDetector;
use Ramsey\Uuid\Uuid;

require_once '../../vendor/autoload.php';

$factory = new CompilerFactory();
$compiler = $factory->getCompiler(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');

//-- Build pass
$passbook = new GenericPassbook('EMP-2026-4471');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Acme Corp');
$passbook->setDescription('Acme Corp Employee Badge');
$passbook->setLogoText('Acme Corp');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(44, 62, 80));
$passbook->prohibitSharing();
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

//-- Link to companion app
$passbook->setAppLaunchURL('https://example.com/app/badge/EMP-2026-4471');
$passbook->addAssociatedStoreIdentifier(987654321);

//-- Office location
$passbook->addLocation(new Location(52.3548, 4.9554));

//-- NFC for door access
$nfc = new Nfc('<EncryptionPublicKey>', 'EMP-2026-4471');
$nfc->requireAuthentication();
$passbook->setNfc($nfc);

//-- Beacon for office floor proximity
$beacon = new Beacon(Uuid::fromString('a4950001-c5b1-4b44-b512-1370f02d74de'));
$beacon->setMajorIdentifier(1);
$beacon->setMinorIdentifier(3);
$beacon->setRelevantText('Welcome to the 3rd floor');
$passbook->addBeacon($beacon);

//-- QR code as fallback
$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::Qr);
$barcode->setMessage('EMP-2026-4471');
$barcode->setAltText('Employee #4471');
$passbook->setBarcode($barcode);

//-- Fields
$name = new Field();
$name->setKey('name');
$name->setValue('John Appleseed');
$passbook->addPrimaryField($name);

$department = new Field();
$department->setKey('department');
$department->setLabel('DEPARTMENT');
$department->setValue('Engineering');
$passbook->addSecondaryField($department);

$employeeId = new Field();
$employeeId->setKey('employeeId');
$employeeId->setLabel('EMPLOYEE ID');
$employeeId->setValue('4471');
$passbook->addAuxiliaryField($employeeId);

$access = new Field();
$access->setKey('access');
$access->setLabel('ACCESS LEVEL');
$access->setValue('Building A, Floors 1-5');
$passbook->addAuxiliaryField($access);

//-- Back fields with contact info and Wi-Fi
$phone = new Field();
$phone->setKey('phone');
$phone->setLabel('IT Support');
$phone->setValue('+31 20 555 0199');
$phone->addDataDetectorType(DataDetector::PhoneNumber);
$passbook->addBackField($phone);

$email = new Field();
$email->setKey('email');
$email->setLabel('HR Department');
$email->setValue('hr@example.com');
$email->addDataDetectorType(DataDetector::Link);
$passbook->addBackField($email);

$wifi = new Field();
$wifi->setKey('wifi');
$wifi->setLabel('Office Wi-Fi');
$wifi->setValue('Network: AcmeCorp-Staff');
$wifi->addSemanticTag(new WifiAccess(new WifiNetwork('AcmeCorp-Staff', 'W1F1P4SS!')));
$passbook->addBackField($wifi);

$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/logo@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/thumbnail.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/thumbnail@2x.png'));

//-- Send data to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="employee-badge.pkpass"');

echo $compiler->compile($passbook);
