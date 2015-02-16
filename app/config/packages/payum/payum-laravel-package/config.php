<?php

use Payum\Core\Storage\FilesystemStorage;
use Payum\LaravelPackage\Action\GetHttpRequestAction;
use Payum\LaravelPackage\Action\ObtainCreditCardAction;
use Payum\LaravelPackage\Storage\EloquentStorage;

$detailsClass = 'Payum\Core\Model\ArrayObject';
$tokenClass = 'Payum\Core\Model\Token';

$getHttpRequestAction = new GetHttpRequestAction();
$obtainCreditCardAction = new ObtainCreditCardAction();


$omnipayDirectPaymentFactory = new \Payum\OmnipayBridge\DirectPaymentFactory();
$stripeJsPaymentFactory = new \Payum\Stripe\JsPaymentFactory();
$stripeCheckoutPaymentFactory = new \Payum\Stripe\CheckoutPaymentFactory();
$paypalExpressCheckoutPaymentFactory = new \Payum\Paypal\ExpressCheckout\Nvp\PaymentFactory();

return array(
    // You can pass on object or a service id from container.
//    'token_storage' => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $tokenClass, 'hash'),
    'token_storage' => new EloquentStorage('Payum\LaravelPackage\Model\Token'),
    'payments' => array(
        // Put here any payment you want too, omnipay, payex, paypa, be2bill or any other. Here's example of paypal and stripe:
        'paypal_ec' => $paypalExpressCheckoutPaymentFactory->create(array(
            'username' => $_SERVER['payum.paypal_express_checkout.username'],
            'password' => $_SERVER['payum.paypal_express_checkout.password'],
            'signature' => $_SERVER['payum.paypal_express_checkout.signature'],
            'sandbox' => true
        )),
        'paypal_ec_plus_eloquent' => $paypalExpressCheckoutPaymentFactory->create(array(
            'username' => $_SERVER['payum.paypal_express_checkout.username'],
            'password' => $_SERVER['payum.paypal_express_checkout.password'],
            'signature' => $_SERVER['payum.paypal_express_checkout.signature'],
            'sandbox' => true
        )),
        'stripe_js' => $stripeJsPaymentFactory->create(array(
            'publishable_key' => $_SERVER['payum.stripe.publishable_key'],
            'secret_key' => $_SERVER['payum.stripe.secret_key'],
            'payum.action.get_http_request' => $getHttpRequestAction,
        )),
        'stripe_checkout' => $stripeCheckoutPaymentFactory->create(array(
            'publishable_key' => $_SERVER['payum.stripe.publishable_key'],
            'secret_key' => $_SERVER['payum.stripe.secret_key'],
            'payum.action.get_http_request' => $getHttpRequestAction,
        )),
        'stripe_direct' => $omnipayDirectPaymentFactory->create(array(
            'type' => 'Stripe',
            'options' => array(
                'apiKey' => $_SERVER['payum.stripe.secret_key'],
                'testMode' => true,
            ),
            'payum.action.get_http_request' => $getHttpRequestAction,
            'payum.action.obtain_credit_card' => $obtainCreditCardAction
        )),
    ),

    'storages' => array(
        'Payum\LaravelPackage\Model\Order' => new EloquentStorage('Payum\LaravelPackage\Model\Order'),
        $detailsClass => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $detailsClass),
    )
);