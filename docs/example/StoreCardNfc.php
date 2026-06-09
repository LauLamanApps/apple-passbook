<?php

/**
 * NFC Store Card Example
 *
 * Demonstrates: NFC-enabled loyalty card for contactless payments and identification
 * at point-of-sale terminals. Uses NFC with authentication, balance semantic tag,
 * and sharing prohibition (required for NFC passes).
 */

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\CompilerFactory;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Field\NumberField;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\MetaData\Nfc;
use LauLamanApps\ApplePassbook\MetaData\SemanticTag\StoreCard\Balance;
use LauLamanApps\ApplePassbook\StoreCardPassbook;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

require_once '../../vendor/autoload.php';

$factory = new CompilerFactory();
$compiler = $factory->getCompiler(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');

//-- Build pass
$passbook = new StoreCardPassbook('NFC-LC-88421');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Coffee House');
$passbook->setDescription('Coffee House Loyalty Card');
$passbook->setLogoText('Coffee House');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(101, 67, 33));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(52.3676, 4.9041)); // Amsterdam

//-- NFC for contactless identification at POS terminals
$nfc = new Nfc('<EncryptionPublicKey>', 'NFC-LC-88421');
$nfc->requireAuthentication();
$passbook->setNfc($nfc);

//-- QR code as fallback for non-NFC terminals
$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::Qr);
$barcode->setMessage('NFC-LC-88421');
$barcode->setAltText('Card #88421');
$passbook->setBarcode($barcode);

//-- Fields
$balance = new NumberField();
$balance->setKey('balance');
$balance->setLabel('BALANCE');
$balance->setValue(42.50);
$balance->setCurrencyCode('EUR');
$balance->addSemanticTag(new Balance('42.50', 'EUR'));
$passbook->addPrimaryField($balance);

$member = new Field();
$member->setKey('member');
$member->setLabel('MEMBER');
$member->setValue('John Appleseed');
$passbook->addSecondaryField($member);

$points = new NumberField();
$points->setKey('points');
$points->setLabel('POINTS');
$points->setValue(1280);
$passbook->addAuxiliaryField($points);

$level = new Field();
$level->setKey('level');
$level->setLabel('STATUS');
$level->setValue('Gold');
$passbook->addAuxiliaryField($level);

$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/strip.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/strip@2x.png'));

//-- Send data to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="storecard-nfc.pkpass"');

echo $compiler->compile($passbook);
