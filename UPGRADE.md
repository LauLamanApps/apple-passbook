# Upgrading to 2.0

## Requirements

- **PHP 8.1 or higher** is now required (was `^7.4|^8.0`)
- The `werkspot/enum` package has been removed

## Enums

All enum classes have been converted from `werkspot/enum` `AbstractEnum` classes to native PHP backed enums.

### Before (1.x)

```php
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;

$barcode->setFormat(BarcodeFormat::pdf417());

// Getting the value
$value = $barcodeFormat->getValue();
```

### After (2.0)

```php
use LauLamanApps\ApplePassbook\Style\BarcodeFormat;

$barcode->setFormat(BarcodeFormat::Pdf417);

// Getting the value
$value = $barcodeFormat->value;
```

### Enum case name mapping

| Class | 1.x method | 2.0 case |
|---|---|---|
| `BarcodeFormat` | `::qr()` | `::Qr` |
| | `::pdf417()` | `::Pdf417` |
| | `::aztec()` | `::Aztec` |
| | `::code128()` | `::Code128` |
| `DataDetector` | `::phoneNumber()` | `::PhoneNumber` |
| | `::link()` | `::Link` |
| | `::address()` | `::Address` |
| | `::calendarEvent()` | `::CalendarEvent` |
| `DateStyle` | `::none()` | `::None` |
| | `::short()` | `::Short` |
| | `::medium()` | `::Medium` |
| | `::long()` | `::Long` |
| | `::full()` | `::Full` |
| `NumberStyle` | `::decimal()` | `::Decimal` |
| | `::percent()` | `::Percent` |
| | `::scientific()` | `::Scientific` |
| | `::spellOut()` | `::SpellOut` |
| `TextAlignment` | `::left()` | `::Left` |
| | `::center()` | `::Center` |
| | `::right()` | `::Right` |
| | `::natural()` | `::Natural` |
| `TransitType` | `::generic()` | `::Generic` |
| | `::air()` | `::Air` |
| | `::boat()` | `::Boat` |
| | `::bus()` | `::Bus` |
| | `::train()` | `::Train` |
| `EventTypeEnum` | `::generic()` | `::Generic` |
| | `::livePerformance()` | `::LivePerformance` |
| | `::movie()` | `::Movie` |
| | `::sports()` | `::Sports` |
| | `::conference()` | `::Conference` |
| | `::convention()` | `::Convention` |
| | `::workshop()` | `::Workshop` |
| | `::socialGathering()` | `::SocialGathering` |

### Removed methods

- `->getValue()` is replaced by `->value` (native backed enum property)
- `->isXxx()` methods no longer exist; use `===` comparison instead:
  ```php
  // Before
  if ($format->isQr()) { ... }

  // After
  if ($format === BarcodeFormat::Qr) { ... }
  ```

## Beacon

`Beacon::setMajorIdentifier()` and `Beacon::setMinorIdentifier()` now accept `int` instead of `string`, matching the Apple specification (16-bit unsigned integer).

```php
// Before
$beacon->setMajorIdentifier('123');

// After
$beacon->setMajorIdentifier(123);
```

## AppleWWDRCA Certificate

The expired `AppleWWDRCA.pem` (expired Feb 2023) has been removed. The G3, G4, G5 and G6
intermediates are now bundled, and the `Signer` auto-selects the one matching the issuer of your
pass type identifier certificate (with `AppleWWDRCAG3.pem` as fallback default). If you were
explicitly passing the path to `AppleWWDRCA.pem`, remove the argument to use auto-selection, or
pass the path of the intermediate you need to override it.

## relevantDate is deprecated

Apple deprecated the singular `relevantDate` key. `setRelevantDate()` still works but is
deprecated; use the new `relevantDates` array instead:

```php
use LauLamanApps\ApplePassbook\MetaData\RelevantDate;

$passbook->addRelevantDate(RelevantDate::forDate(new DateTimeImmutable('2026-08-01T20:00:00+02:00')));
// or an explicit relevancy window:
$passbook->addRelevantDate(RelevantDate::forInterval($start, $end));
```

## Stricter validation

- Image filenames must be plain file names: `LocalImage` and the `Compressor` now reject names
  containing directory separators or colliding with `pass.json`, `manifest.json`, or `signature`.
- `Notifier::notify()` rejects non-hexadecimal push tokens with a `NotifierException`.
- Signing failures (`openssl_pkcs7_sign`) and signing without a configured certificate now throw
  a `CertificateException` instead of silently producing a corrupt pass.

## Signer

The `Signer` class now uses typed properties `\OpenSSLCertificate` and `\OpenSSLAsymmetricKey` instead of `mixed`/`resource`. This should not require any changes in consumer code.
