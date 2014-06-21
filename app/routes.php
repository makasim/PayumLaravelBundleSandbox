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
Route::get('/payment/done', array('as' => 'payment_done', 'uses' => 'PaymentController@done'));
Route::get('/payment/paypal/express-checkout/prepare', array('as' => 'paypal_es_prepare', 'uses' => 'PaypalController@prepareExpressCheckout'));
