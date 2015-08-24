<?php

use Payum\Core\Storage\FilesystemStorage;
use Payum\LaravelPackage\Storage\EloquentStorage;

$detailsClass = 'Payum\Core\Model\ArrayObject';
$tokenClass = 'Payum\Core\Model\Token';

return array(
    // You can pass on object or a service id from container.
//    'token_storage' => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $tokenClass, 'hash'),
    'token_storage' => new EloquentStorage('Payum\LaravelPackage\Model\Token'),
    'factories' => [],
    'gateways' => [
        // Put here any gateway you want too, omnipay, payex, paypa, be2bill or any other. Here's example of paypal and stripe:
        'paypal_ec' => 'acme_payment.gateway.paypal_express_checkout',
        'paypal_ec_plus_eloquent' => 'acme_payment.gateway.paypal_express_checkout',
        'stripe_js' => 'acme_payment.gateway.stripe_js',
        'stripe_checkout' => 'acme_payment.gateway.stripe_checkout',
        'stripe_direct' => 'acme_payment.gateway.stripe_omnipay',
    ],

    'storages' => [
        'Payum\LaravelPackage\Model\Payment' => new EloquentStorage('Payum\LaravelPackage\Model\Payment'),
        $detailsClass => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $detailsClass),
    ]
);