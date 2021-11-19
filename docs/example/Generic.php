<?php

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\GenericPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\DateField;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Field\NumberField;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use LauLamanApps\ApplePassbook\Style\DateStyle;
use LauLamanApps\ApplePassbook\Style\NumberStyle;
use LauLamanApps\ApplePassbook\Style\TextAlignment;

require_once '../../vendor/autoload.php';

//-- Set up compiler and its dependencies
$manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__  . '/../../certificates/certificate.p12', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

//-- Build pass
$passbook = new GenericPassbook('8j23fm3');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Toy Town');
$passbook->setDescription('Toy Town Membership');
$passbook->setLogoText('Toy Town');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(197, 31, 31));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(37.6189722, -122.3748889));
$passbook->addLocation(new Location(37.33182, -122.03118));

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::pdf417);
$barcode->setMessage('123456789');
$passbook->setBarcode($barcode);

$member = new Field();
$member->setKey('member');
$member->setValue('Johnny Appleseed');
$passbook->addPrimaryField($member);

$level = new Field();
$level->setKey('level');
$level->setLabel('LEVEL');
$level->setValue('Platinum');
$passbook->addAuxiliaryField($level);

$favorite = new Field();
$favorite->setKey('favorite');
$favorite->setLabel('FAVORITE TOY');
$favorite->setValue('Bucky Ball Magnets');
$favorite->setTextAlignment(TextAlignment::right);
$passbook->addAuxiliaryField($favorite);

$numberStyle = new NumberField();
$numberStyle->setKey('numberStyle');
$numberStyle->setLabel('spelled out TOY');
$numberStyle->setValue(200);
$numberStyle->setNumberStyle(NumberStyle::spellOut);
$passbook->addBackField($numberStyle);

$currency = new NumberField();
$currency->setKey('currency');
$currency->setLabel('in Reals');
$currency->setValue(200);
$currency->setCurrencyCode('BRL');
$passbook->addBackField($currency);

$dateFull = new DateField();
$dateFull->setKey('dateFull');
$dateFull->setLabel('full date');
$dateFull->setDate(new DateTimeImmutable('1980-05-07T10:00-05:00'));
$dateFull->setDateStyle(DateStyle::full);
$passbook->addBackField($dateFull);

$timeFull = new DateField();
$timeFull->setKey('timeFull');
$timeFull->setLabel('full time');
$timeFull->setDate(new DateTimeImmutable('1980-05-07T10:00-05:00'));
$timeFull->setTimeStyle(DateStyle::full);
$passbook->addBackField($timeFull);

$dateTime = new DateField();
$dateTime->setKey('dateTime');
$dateTime->setLabel('short date and time');
$dateTime->setDate(new DateTimeImmutable('1980-05-07T10:00-05:00'));
$dateTime->setDateStyle(DateStyle::short);
$timeFull->setTimeStyle(DateStyle::short);
$passbook->addBackField($dateTime);

$relStyle = new DateField();
$relStyle->setKey('relStyle');
$relStyle->setLabel('relative date');
$relStyle->setDate(new DateTimeImmutable('1980-05-07T10:00-05:00'));
$relStyle->setDateStyle(DateStyle::short);
$relStyle->isRelative();
$passbook->addBackField($relStyle);

$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/logo@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/thumbnail.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Generic/thumbnail@2x.png'));

//-- Send data too the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="generic.pkpass"');

echo $compiler->compile($passbook);