<?php

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;
use LauLamanApps\ApplePassbook\CouponPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\DateField;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;
use LauLamanApps\ApplePassbook\Style\DateStyle;

require_once '../../vendor/autoload.php';

//-- Set up compiler and its dependencies
$manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__ . '/../../certificates/certificate.p12', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

//-- Build pass
$passbook = new CouponPassbook('E5982H-I2');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('Paw Planet');
$passbook->setDescription('Paw Planet Coupon');
$passbook->setLogoText('Paw Planet');
$passbook->setForegroundColor(new Rgb(255, 255, 255));
$passbook->setBackgroundColor(new Rgb(206, 140, 53));
$passbook->setWebService('https://example.com/passes/', 'vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc');

$passbook->addLocation(new Location(37.6189722, -122.3748889));
$passbook->addLocation(new Location(37.33182, -122.03118));

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::pdf417());
$barcode->setMessage('123456789');
$passbook->setBarcode($barcode);

$offer = new Field();
$offer->setKey('offer');
$offer->setLabel('Any premium dog food');
$offer->setValue('20% off');
$passbook->addPrimaryField($offer);

$expires = new DateField();
$expires->setKey('expires');
$expires->setLabel('EXPIRES');
$expires->setDate(new DateTimeImmutable('2013-04-24T10:00-05:00'));
$expires->isRelative();
$expires->setDateStyle(DateStyle::short());
$passbook->addAuxiliaryField($expires);

$passbook->addImage(new LocalImage(__DIR__ . '/files/Coupon/icon.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Coupon/icon@2x.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Coupon/logo.png'));
$passbook->addImage(new LocalImage(__DIR__ . '/files/Coupon/logo@2x.png'));

//-- Send data too the browser
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="coupon.pkpass"');

echo $compiler->compile($passbook);
