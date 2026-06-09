# CHANGELOG

### 2.0.0
- **Breaking:** Require PHP 8.1+
- **Breaking:** Convert style classes to native PHP enums (`BarcodeFormat`, `DataDetector`, `DateStyle`, `NumberStyle`, `TextAlignment`, `TransitType`, `EventTypeEnum`)
- Add full Apple Wallet PassKit support for `BoardingPassbook` and `EventTicketPassbook`
- Add semantic tag support for BoardingPass and EventTicket
- Add new Passbook base properties and URL support
- Add `Notifier` for push-based pass updates via APNs (supports `.p12` and `.pem` certificates)
- Add `ApnsEnvironment` enum for APNs production/sandbox selection
- Update certificates: remove expired AppleWWDRCA, add AppleWWDRCAG6
- Default intermediate certificate changed to AppleWWDRCAG3
- Update CI for PHP 8.1–8.4
- Fix all PHPStan level 8 errors
- Fix PHP 8.4 implicit nullable parameter deprecations
- Upgrade PHPUnit to ^10.0|^11.0

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
