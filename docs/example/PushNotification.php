<?php

/**
 * Push Notification Example
 *
 * Demonstrates: sending push notifications to trigger pass updates via APNs.
 *
 * When a pass is registered on a device via the web service, Apple provides a
 * push token. Use the Notifier to send an empty push notification that tells
 * the device to fetch an updated version of the pass from your web service.
 *
 * @see https://developer.apple.com/documentation/walletpasses/adding-a-web-service-to-update-passes
 */

declare(strict_types=1);

use LauLamanApps\ApplePassbook\Build\ApnsEnvironment;
use LauLamanApps\ApplePassbook\Build\Exception\NotifierException;
use LauLamanApps\ApplePassbook\Build\Notifier;

require_once '../../vendor/autoload.php';

//-- Using a .p12 certificate (as provided by Apple)
$notifier = new Notifier(
    __DIR__ . '/../../certificates/certificate.p12',
    '<CertificatePassword>',
);

//-- Or using a .pem certificate
// $notifier = new Notifier(__DIR__ . '/../../certificates/certificate.pem');

//-- For sandbox/development environments
// $notifier = new Notifier(
//     __DIR__ . '/../../certificates/certificate.p12',
//     '<CertificatePassword>',
//     ApnsEnvironment::Sandbox,
// );

//-- Send a push notification to trigger a pass update
$pushToken = '<DevicePushToken>'; // Received during device registration

try {
    $notifier->notify($pushToken);
    echo 'Push notification sent successfully.';
} catch (NotifierException $e) {
    echo 'Failed to send push notification: ' . $e->getMessage();
}
