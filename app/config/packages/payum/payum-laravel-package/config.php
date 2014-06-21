<?php

use Buzz\Client\Curl;
use Omnipay\Common\GatewayFactory;
use Payum\Core\Storage\FilesystemStorage;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Paypal\ExpressCheckout\Nvp\PaymentFactory as PaypalPaymentFactory;
use Payum\OmnipayBridge\PaymentFactory as OmnipayPaymentFactory;

$detailsClass = 'Payum\Core\Model\ArrayObject';
$tokenClass = 'Payum\Core\Model\Token';

$gatewayFactory = new GatewayFactory;
$gatewayFactory->find();

$stripeGateway = $gatewayFactory->create('Stripe');
$stripeGateway->setApiKey('REPLACE IT');
$stripeGateway->setTestMode(true);



return array(
    // You can pass on object or a service id from container.
    'token_storage' => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $tokenClass, 'hash'),
    'payments' => array(
        // Put here any payment you want too, omnipay, payex, paypa, be2bill or any other. Here's example of paypal:
        'paypal_es' => PaypalPaymentFactory::create(new Api(new Curl, array(
            'username' => 'REPLACE WITH YOURS',
            'password' => 'REPLACE WITH YOURS',
            'signature' => 'REPLACE WITH YOURS',
            'sandbox' => true
        ))),
        'omnipay_stripe' => OmnipayPaymentFactory::create($stripeGateway),
    ),
    'storages' => array(
        $detailsClass => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $detailsClass),
    )
);