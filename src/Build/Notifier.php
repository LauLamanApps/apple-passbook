<?php

declare(strict_types=1);

namespace LauLamanApps\ApplePassbook\Build;

use LauLamanApps\ApplePassbook\Build\Exception\NotifierException;

class Notifier
{
    /**
     * @throws NotifierException
     */
    public function __construct(
        private readonly string $certificatePath,
        #[\SensitiveParameter] private readonly ?string $certificatePassword = null,
        private readonly ApnsEnvironment $environment = ApnsEnvironment::Production,
    ) {
        if (!file_exists($this->certificatePath)) {
            throw NotifierException::certificateNotFound($this->certificatePath);
        }
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

        if ($pushToken === '' || !ctype_xdigit($pushToken)) {
            throw NotifierException::invalidPushToken();
        }

        $url = sprintf('%s/3/device/%s', $this->environment->value, $pushToken);

        $ch = curl_init($url);

        if ($ch === false) {
            throw NotifierException::connectionFailed('Failed to initialize cURL');
        }

        curl_setopt_array($ch, [
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => '{}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLCERT => $this->certificatePath,
            CURLOPT_HTTPHEADER => [
                'apns-push-type: alert',
            ],
            ...$this->getCertificateOptions(),
        ]);

        $response = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!is_string($response)) {
            $error = curl_error($ch);
            curl_close($ch);

            throw NotifierException::connectionFailed($error);
        }

        curl_close($ch);

        if ($httpStatusCode !== 200) {
            /** @var array{reason?: string} $body */
            $body = json_decode($response, true);
            $reason = $body['reason'] ?? 'Unknown';

            throw NotifierException::rejected($httpStatusCode, $reason);
        }
    }

    /**
     * @return array<int, mixed>
     */
    private function getCertificateOptions(): array
    {
        $isP12 = str_ends_with(strtolower($this->certificatePath), '.p12');

        $options = [];

        if ($isP12) {
            $options[CURLOPT_SSLCERTTYPE] = 'P12';
        }

        if ($this->certificatePassword !== null) {
            $options[CURLOPT_SSLCERTPASSWD] = $this->certificatePassword;
        }

        return $options;
    }
}
