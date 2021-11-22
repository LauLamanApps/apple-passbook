Apple Passbook
===============
This package provides a simple OOP integration of the [Apple Passbook API][ApplePassbookApi] for your PHP project.

[![GithubCi](https://github.com/LauLamanApps/apple-passbook/workflows/CI/badge.svg)](https://github.com/LauLamanApps/apple-passbook/actions?query=workflow%3ACI)
[![Build Status](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/build.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/laulamanapps/apple-passbook/v/stable)](https://packagist.org/packages/laulamanapps/apple-passbook)
[![License](https://poser.pugx.org/laulamanapps/apple-passbook/license)](https://packagist.org/packages/laulamanapps/apple-passbook)

Installation
---
With [composer](http://packagist.org), add:

```bash
$ composer require laulamanapps/apple-passbook
```

Or if your using Symfony install [laulamanapps/apple-passbook-bundle](https://github.com/LauLamanApps/apple-passbook-bundle):

```bash
$ composer require laulamanapps/apple-passbook-bundle
```

Run Tests
---
We use [act][act] to run tests which runs github actions locally: 

```bash
$ act -P ubuntu-latest=shivammathur/node:latest
```

Get certificate
---

Head over to the [Apple Developer Portal][AppleDeveloperPortal] to get yourself a certificate to sign your passbooks with.

[Convert](docs/certificate.md) the certificate and key to a .p12 file using the **Keychain Access**

Setup Compiler
---
```php
use LauLamanApps\ApplePassbook\Build\CompilerFactory;

$factory = new CompilerFactory();
$compiler = $factory->getCompiler('<PathToCertificate>', '<CertificatePassword>');
```

AppleWWDRA certificate.
---
Included ar 2 AppleWWDRCA certificates:
 - AppleWWDRCA.pem - _Expires feb 3 2023_
 - AppleWWDRCAG3.pem - _Expires feb 20 2030_

By default AppleWWDRCA is used if you want to use the otherone you can do so by setting its file path as the 3rd option in the `CompilerFactory` or calling `setAppleWWDRCA()` on the `Signer` class for custom implementation

Create Passbook
---
```php
use LauLamanApps\ApplePassbook\EventTicketPassbook;
use LauLamanApps\ApplePassbook\MetaData\Barcode;
use LauLamanApps\ApplePassbook\MetaData\Field\Field;
use LauLamanApps\ApplePassbook\MetaData\Image\LocalImage;
use LauLamanApps\ApplePassbook\MetaData\Location;
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;
use LauLamanApps\ApplePassbook\Style\Color\Rgb;

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

$passbook->addImage(new LocalImage('/files/Event/background.png'));
$passbook->addImage(new LocalImage('/files/Event/icon.png'));
$passbook->addImage(new LocalImage('/files/Event/logo.png'));
$passbook->addImage(new LocalImage('/files/Event/thumbnail.png'));

```

Compile Passbook
---
```php
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.apple.pkpass');
header('Content-Disposition: filename="boardingpass.pkpass"');

echo $compiler->compile($passbook);
```

Examples
---
For the examples to work place the certificate P12 file in the `/certificates` folder and fill out the required information in the example scripts:
`<CertificatePassword>`, `<TeamId>`, `<PassTypeId>`


Example php scripts can be found in `docs/example`:

- [BoardingPass](docs/example/BoardingPass.php)
- [Coupon](docs/example/Coupon.php)
- [Event](docs/example/Event.php)
- [Generic](docs/example/Generic.php)
- [StoreCard](docs/example/StoreCard.php)


Credits
---

This package has been developed by [LauLaman][LauLaman].

[act]: https://github.com/nektos/act
[ApplePassbookApi]: https://developer.apple.com/documentation/passkit
[AppleDeveloperPortal]: https://developer.apple.com/account/resources/certificates/list
[LauLaman]: https://github.com/LauLaman
