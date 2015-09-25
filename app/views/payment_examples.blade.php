@extends('layout')

@section('content')
<ul>
    <li><a href="{{ URL::route('paypal_ec_prepare') }}">Paypal Express Checkout</a></li>
    <li><a href="{{ URL::route('paypal_ec_prepare_plus_eloquent') }}">Paypal Express Checkout Plus EloquentStorage</a></li>
    <li><a href="{{ URL::route('paypal_ec_stored_in_database') }}">Paypal Express Config Stored In Database</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_prepare_credit_card') }}">Stripe via Omnipay. Obtain Credit card</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_prepare') }}">Stripe via Omnipay</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_js_prepare') }}">Stripe.Js</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_checkout_prepare') }}">Stripe Checkout</a></li>
</ul>
@stop