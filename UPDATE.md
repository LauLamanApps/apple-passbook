# UPDATE v1 to V2


### ENUMS
WerkspotEnum has been replaced and has been removed as a dependency in favor of PHP 8.1 native Enums. To update simply remove the parentheses `()`
```diff
$barcode = new Barcode();
$barcode->setMessage('barcode');
- $barcode->setFormat(BarcodeFormat::code128());
+ $barcode->setFormat(BarcodeFormat::code128);
```

### Simpler Compiler bootstrapping
With PHP 8.1's new ['New in initializers'](https://wiki.php.net/rfc/new_in_initializers) expression bootstrapping becomes much simpler when using the default provided dependencies:
As a result of this the `$manifestGenerator`, `$signer` dependencies in the `Compiler` class are **_swapped_**
```diff
- $manifestGenerator = new ManifestGenerator();
$signer = new Signer(__DIR__  . '/../../certificates/certificate.p12', '<CertificatePassword>');
- $compressor = new Compressor(new ZipArchive());

- $compiler = new Compiler($manifestGenerator, $signer, $compressor);
+ $compiler = new Compiler($signer);
```


### Changes to `Barcode::class`
- `messageEncoding` added to the constructor as the 3rd argument
- `altText` is now the 4rd argument of the constructor