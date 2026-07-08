# CHANGELOG

### 2.0.1
- Fix: the AppleWWDRCAG4/G5 intermediates announced in 2.0.0 were missing from the release (excluded by the `certificates/*` gitignore rule); the gitignore now whitelists all `AppleWWDRCAG*` files

### 2.0.0
- **Breaking:** Require PHP 8.1+
- **Breaking:** Convert style classes to native PHP enums (`BarcodeFormat`, `DataDetector`, `DateStyle`, `NumberStyle`, `TextAlignment`, `TransitType`, `EventTypeEnum`)
- Add full Apple Wallet PassKit support for `BoardingPassbook` and `EventTicketPassbook`
- Add semantic tag support for BoardingPass and EventTicket
- Add new Passbook base properties and URL support
- Add [`relevantDates`](https://developer.apple.com/documentation/walletpasses/pass/relevantdates-data.dictionary) support via `Passbook::addRelevantDate()` and the `RelevantDate` value object (single date or start/end interval); `setRelevantDate()` is deprecated (Apple deprecated the singular `relevantDate` key)
- Add [`upcomingPassInformation`](https://developer.apple.com/documentation/walletpasses/upcomingpassinformationentry) (iOS 26) support via `Passbook::addUpcomingPassInformation()` and `UpcomingPassInformationEntry` (with `DateInformation`, `Urls`, `EntryImages`, `ImageUrlEntry`)
- Add `Notifier` for push-based pass updates via APNs (supports `.p12` and `.pem` certificates)
- Add `ApnsEnvironment` enum for APNs production/sandbox selection
- `suppressStripShine()` now accepts a bool (`suppressStripShine(false)` re-enables the shine effect, no-argument calls behave as before); the key is only emitted once explicitly set
- Update certificates: remove expired AppleWWDRCA, add AppleWWDRCAG4, AppleWWDRCAG5 and AppleWWDRCAG6
- The `Signer` auto-selects the bundled Apple WWDR intermediate certificate matching the issuer of the signing certificate (G3–G6); explicit `setAppleWWDRCA()` still wins, AppleWWDRCAG3 is the fallback default
- Security: `openssl_pkcs7_sign` failures now throw a `CertificateException` instead of silently producing a pass with a corrupt signature
- Security: signing with no certificate configured throws a `CertificateException` instead of a typed-property `Error`
- Security: the temporary build directory is created with mode `0700` and creation failures throw
- Security: image filenames are validated (no directory parts, no collisions with `pass.json`/`manifest.json`/`signature`) in both `LocalImage` and `Compressor`
- Security: `Notifier::notify()` validates that the push token is hexadecimal before building the APNs URL
- Security: `pass.json` and `manifest.json` are encoded with `JSON_THROW_ON_ERROR` (encoding failures no longer produce an empty pass)
- Fix inverted validation in `Compiler`: compiler-level `passTypeIdentifier`/`teamIdentifier` defaults were rejected instead of applied to passbooks that lack them
- Update CI for PHP 8.1–8.4
- Fix all PHPStan level 8 errors
- Fix PHP 8.4 implicit nullable parameter deprecations
- Upgrade PHPUnit to ^10.0|^11.0 and convert doc-comment metadata to attributes (PHPUnit 12 ready)

### 1.1.4
- Add support for [Semantic Tag Data](https://developer.apple.com/documentation/walletpasses/semantictags)
- Add support for [Beacons](https://developer.apple.com/documentation/walletpasses/pass/beacons)
- Add support for [NFC](https://developer.apple.com/documentation/walletpasses/pass/nfc)
- Add support for [sharingProhibited](https://developer.apple.com/documentation/walletpasses/pass)
- Add support for [groupingIdentifier](https://developer.apple.com/documentation/walletpasses/pass)
- Add support for [suppressStripShine](https://developer.apple.com/documentation/walletpasses/pass)
- Add factory for Compiler
- Bundle with AppleWWDRCAG3.pem

### 1.1.3
- Fix [bug](https://github.com/LauLamanApps/apple-passbook/issues/8) that prevent Expiration Date from being set (thanks to @ercole79)
