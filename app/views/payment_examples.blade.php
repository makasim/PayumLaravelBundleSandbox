@extends('layout')

@section('content')
<ul>
    <li><a href="{{ URL::route('paypal_ec_prepare') }}">Paypal Express Checkout</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_prepare_credit_card') }}">Stripe via Omnipay. Obtain Credit card</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_prepare') }}">Stripe via Omnipay</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_js_prepare') }}">Stripe.Js</a></li>
    <li><a href="{{ URL::route('omnipay_stripe_checkout_prepare') }}">Stripe Checkout</a></li>
</ul>
@stop