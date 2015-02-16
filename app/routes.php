<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'payment_examples', 'uses' => 'PaymentController@examples'));
Route::get('/payment/done/{payum_token}', array('as' => 'payment_done', 'uses' => 'PaymentController@done'));
Route::get('/payment/done-order/{payum_token}', array('as' => 'payment_done_order', 'uses' => 'PaymentController@doneOrder'));
Route::get('/payment/paypal/express-checkout/prepare', array('as' => 'paypal_ec_prepare', 'uses' => 'PaypalController@prepareExpressCheckout'));
Route::get('/payment/paypal/express-checkout/prepare-plus-eloquent', array('as' => 'paypal_ec_prepare_plus_eloquent', 'uses' => 'PaypalController@prepareExpressCheckoutPlusEloquent'));
Route::get('/payment/stripe/js/prepare', array('as' => 'omnipay_stripe_js_prepare', 'uses' => 'StripeController@prepareJs'));
Route::get('/payment/stripe/checkout/prepare', array('as' => 'omnipay_stripe_checkout_prepare', 'uses' => 'StripeController@prepareCheckout'));
Route::get('/payment/stripe/direct/prepare', array('as' => 'omnipay_stripe_prepare', 'uses' => 'OmnipayController@prepareStripe'));
Route::get('/payment/stripe/direct/prepare_obtain_credit_card', array('as' => 'omnipay_stripe_prepare_credit_card', 'uses' => 'OmnipayController@prepareStripeObtainCreditCard'));
