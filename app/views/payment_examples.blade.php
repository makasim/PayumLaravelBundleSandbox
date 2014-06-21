@extends('layout')

@section('content')
<ul>
    <li><a href="{{ URL::route('paypal_es_prepare') }}">Paypal Express Checkout</a></li>
</ul>
@stop