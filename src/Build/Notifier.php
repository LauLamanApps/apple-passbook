<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\NotifierException;

class Notifier
{
    private const APNS_PRODUCTION = 'https://api.push.apple.com';
    private const APNS_SANDBOX = 'https://api.sandbox.push.apple.com';

    private string $pemCertificatePath;

    /**
     * @throws NotifierException
     */
    public function __construct(
        string $certificatePath,
        #[\SensitiveParameter] string $certificatePassword,
        private readonly bool $sandbox = false,
    ) {
        $this->pemCertificatePath = $this->convertToPem($certificatePath, $certificatePassword);
    }

    /**
     * Send a push notification to trigger a pass update on the device.
     *
     * @param string $pushToken The device push token (received during device registration)
     *
     * @throws NotifierException
     */
    public function notify(string $pushToken): void
    {
        if (!extension_loaded('curl') || !defined('CURL_HTTP_VERSION_2_0')) {
            throw NotifierException::missingCurl();
        }

        $url = sprintf('%s/3/device/%s', $this->getApnsHost(), $pushToken);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => '{}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLCERT => $this->pemCertificatePath,
            CURLOPT_HTTPHEADER => [
                'apns-push-type: alert',
            ],
        ]);

        $response = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            throw NotifierException::connectionFailed($error);
        }

        curl_close($ch);

        if ($httpStatusCode !== 200) {
            $body = json_decode($response, true);
            $reason = $body['reason'] ?? 'Unknown';

            throw NotifierException::rejected($httpStatusCode, $reason);
        }
    }

    private function getApnsHost(): string
    {
        return $this->sandbox ? self::APNS_SANDBOX : self::APNS_PRODUCTION;
    }

    /**
     * Convert a P12 certificate to PEM format for use with cURL.
     *
     * @throws NotifierException
     */
    private function convertToPem(string $certificatePath, string $certificatePassword): string
    {
        if (!file_exists($certificatePath)) {
            throw NotifierException::connectionFailed(sprintf('Certificate file not found: %s', $certificatePath));
        }

        $p12Content = file_get_contents($certificatePath);

        if ($p12Content === false) {
            throw NotifierException::connectionFailed(sprintf('Could not read certificate file: %s', $certificatePath));
        }

        $data = [];
        if (!openssl_pkcs12_read($p12Content, $data, $certificatePassword)) {
            throw NotifierException::connectionFailed('Failed to read PKCS12 certificate. Check the password.');
        }

        $pemPath = sys_get_temp_dir() . '/apple_passbook_push_' . md5($certificatePath) . '.pem';
        $pemContent = $data['cert'] . "\n" . $data['pkey'];

        if (file_put_contents($pemPath, $pemContent) === false) {
            throw NotifierException::connectionFailed(sprintf('Could not write PEM file: %s', $pemPath));
        }

        chmod($pemPath, 0600);

        return $pemPath;
    }
}
