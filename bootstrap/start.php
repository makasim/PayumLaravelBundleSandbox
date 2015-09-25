<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

use Payum\LaravelPackage\Model\GatewayConfig;
use Payum\LaravelPackage\Model\Payment;

$app = new Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

$env = $app->detectEnvironment(array(

	'local' => array('dev.payum-laravel-bundle-sandbox.com'),

));

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$app->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Load The Application
|--------------------------------------------------------------------------
|
| Here we will load this Illuminate application. We will keep this in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

$framework = $app['path.base'].
                 '/vendor/laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

App::resolving('payum.builder', function(\Payum\Core\PayumBuilder $payumBuilder) {
    $payumBuilder
        // this method registers filesystem storages, consider to change them to something more
        // sophisticated, like eloquent storage
        ->addDefaultStorages()

        ->addGateway('paypal_ec', [
            'factory' => 'paypal_express_checkout',
            'username' => $_SERVER['payum.paypal_express_checkout.username'],
            'password' => $_SERVER['payum.paypal_express_checkout.password'],
            'signature' => $_SERVER['payum.paypal_express_checkout.signature'],
            'sandbox' => true
        ])
        ->addGateway('stripe_js', [
            'factory' => 'stripe_js',
            'publishable_key' => $_SERVER['payum.stripe.publishable_key'],
            'secret_key' => $_SERVER['payum.stripe.secret_key'],
        ])
        ->addGateway('stripe_checkout', [
            'factory' => 'stripe_checkout',
            'publishable_key' => $_SERVER['payum.stripe.publishable_key'],
            'secret_key' => $_SERVER['payum.stripe.secret_key'],
        ])
        ->addGateway('stripe_direct', [
            'factory' => 'omnipay_direct',
            'type' => 'Stripe',
            'options' => array(
                'apiKey' => $_SERVER['payum.stripe.secret_key'],
                'testMode' => true,
            ),
        ])

        ->addStorage(Payment::class, new \Payum\LaravelPackage\Storage\EloquentStorage(Payment::class))

        ->setGatewayConfigStorage(new \Payum\LaravelPackage\Storage\EloquentStorage(GatewayConfig::class))
    ;
});

return $app;
