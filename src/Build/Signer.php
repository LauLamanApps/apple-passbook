<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Passbook;
use LogicException;

final class Signer
{
    public const FILENAME = 'signature';

    /**
     * @var string
     */
    private $certificate;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $appleWWDRCA;

    public function __construct(?string $certificatePath = null, ?string $password = null)
    {
        if ($certificatePath !== null && $password !== null) {
            $this->setCertificate($certificatePath, $password);
        }

        $this->setAppleWWDRCA(__DIR__ . '/../../certificates/AppleWWDRCA.pem');
    }

    public function setCertificate(string $path, string $password): void
    {
        if (!file_exists($path)) {
            throw new LogicException(
                sprintf(
                    'Could not load certificate file \'%s\'. Either it does not exist or the system had no rights to the file.',
                    $path
                )
            );
        }

        $data = [];
        if (!openssl_pkcs12_read(file_get_contents($path), $data, $password)) {
            throw new LogicException(
                sprintf(
                    'Invalid certificate file \'%s\'. Make sure you have a P12 certificate that also contains a private key, and you have specified the correct password!',
                    $path
                )
            );
        }

        $this->certificate = openssl_x509_read($data['cert']);
        $this->privateKey = openssl_pkey_get_private($data['pkey'], $password);
    }

    public function setAppleWWDRCA(string $path): void
    {
        if (!file_exists($path)) {
            throw new LogicException(
                sprintf(
                    'Could not load certificate file \'%s\'. Either it does not exist or the system had no rights to the file.',
                    $path
                )
            );
        }
        $this->appleWWDRCA = $path;
    }

    public function sign(Passbook $passbook, string $temporaryDirectory): void
    {
        $openSslArguments = [
            $temporaryDirectory . ManifestGenerator::FILENAME,
            $temporaryDirectory . self::FILENAME,
            $this->certificate,
            $this->privateKey,
            [],
            PKCS7_BINARY | PKCS7_DETACHED
        ];

        if ($this->appleWWDRCA) {
            $openSslArguments[] = $this->appleWWDRCA;
        }

        call_user_func_array('openssl_pkcs7_sign', $openSslArguments);

        $signature = file_get_contents($temporaryDirectory . self::FILENAME);
        $signature = $this->convertPEMtoDER($signature);
        file_put_contents($temporaryDirectory . self::FILENAME, $signature);
    }

    private function convertPEMtoDER(string $signature): string
    {
        $begin = 'filename="smime.p7s"';
        $end = '------';
        $signature = substr($signature, strpos($signature, $begin) + strlen($begin));

        $signature = substr($signature, 0, strpos($signature, $end));
        $signature = trim($signature);
        $signature = base64_decode($signature);

        return $signature;
    }
}
