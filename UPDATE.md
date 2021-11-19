# UPDATE v1 to V2

### ENUMS
WerkspotEnum has been replaced and has been removed as a dependency in favor of PHP 8.1 native Enums. To update simply remove the parentheses `()`
```diff
$barcode = new Barcode();
$barcode->setMessage('barcode');
- $barcode->setFormat(BarcodeFormat::code128());
+ $barcode->setFormat(BarcodeFormat::code128);
```