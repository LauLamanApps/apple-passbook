<?php

declare(strict_types=1);

use LauLamanApps\ApplePassbook\BoardingPassbook;
use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Field\NumberField;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\StoreCardPassbook;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

require_once '../../vendor/autoload.php';

//-- Set up compiler and its dependencies
$manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__  . '/../../certificates/certificate.p12', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

//-- Build pass
$passbook = new StoreCardPassbook('p69f2J');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Organic Produce');
$passbook->setDescription('Organic Produce Loyalty Card');
$passbook->setLogoText('Organic Produce');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(55, 117, 50));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(37.6189722, -122.3748889));

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::pdf417());
$barcode->setMessage('123456789');
$passbook->setBarcode($barcode);

$balance = new NumberField();
$balance->setKey('balance');
$balance->setLabel('remaining balance');
$balance->setValue(21.75);
$balance->setCurrencyCode('USD');
$passbook->addPrimaryField($balance);

$deal = new Field();
$deal->setKey('deal');
$deal->setLabel('Deal of the Day');
$deal->setValue('Lemons');
$passbook->addAuxiliaryField($deal);

$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/background.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/background@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/strip.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/StoreCard/strip@2x.png'));

//-- Send data too the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="boardingpass.pkpass"');

echo $compiler->compile($passbook);