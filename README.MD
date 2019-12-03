Apple Passbook
===============
This package provides a simple OOP integration of the [Apple Passbook API][ApplePassbookApi] for your PHP project.

[![GithubCi](https://github.com/LauLamanApps/apple-passbook/workflows/CI/badge.svg?name=lol)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/build.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/apple-passbook/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/laulamanapps/apple-passbook-bundle/v/stable)](https://packagist.org/packages/laulamanapps/apple-passbook-bundle)
[![License](https://poser.pugx.org/laulamanapps/apple-passbook-bundle/license)](https://packagist.org/packages/laulamanapps/apple-passbook-bundle)

Installation
---
With [composer](http://packagist.org), add:

```bash
$ composer require laulamanapps/apple-passbook
```

Or if your useing Symfony:

```bash
$ composer require laulamanapps/apple-passbook-bundle
```

Run Tests
---
To make sure everything works you can run tests:

```bash
$ make tests-unit 
$ make tests-integration 
$ make tests-infection 
```

Get certificate
---

Head over to the [Apple Developer Portal][AppleDeveloperPortal] to get yourself a certificate to sign your passbooks with.

[Convert](docs/certificate.md) the certificate and key to a .p12 file using the **Keychain Access**

Setup Compiler
---
```php
use LauLamanApps\ApplePassbook\Build\Compiler;
use LauLamanApps\ApplePassbook\Build\Compressor;
use LauLamanApps\ApplePassbook\Build\ManifestGenerator;
use LauLamanApps\ApplePassbook\Build\Signer;

$manifestGenerator = new ManifestGenerator();
$signer = new Signer('<PathToCertificate>', '<CertificatePassword>');
$compressor = new Compressor(new ZipArchive());

$compiler = new Compiler($manifestGenerator, $signer, $compressor);

```

Create Passbook
---
```php
use LauLamanApps\ApplePassbook\GenericPassbook;

$passbook = new GenericPassbook('<SerialNumber>');
$passbook->setTeamIdentifier('<TeamId>');
$passbook->setPassTypeIdentifier('<PassTypeId>');
$passbook->setOrganizationName('KLM');
$passbook->setDescription('KLM Boarding Pass');

$barcode = new Barcode();
$barcode->setFormat(BarcodeFormat::aztec());
$barcode->setMessage('123456');
$barcode->setAltText('123 456');
$passbook->setBarcode($barcode);

$date = new Field();
$date->setKey('name');
$date->setLabel('Date');
$date->setValue('12 Nov');
$date->setTextAlignment(TextAlignment::left());
$passbook->addHeaderField($date);

$gate = new Field();
$gate->setKey('gate');
$gate->setLabel('Gate');
$gate->setValue('D79');
$gate->setTextAlignment(TextAlignment::left());
$passbook->addHeaderField($gate);

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
For the examples to work place the certificate P12 file in the `/certificates` folder and fill out the required information:
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

[ApplePassbookApi]: https://developer.apple.com/documentation/passkit
[AppleDeveloperPortal]: https://developer.apple.com/account/resources/certificates/list
[LauLaman]: https://github.com/LauLaman