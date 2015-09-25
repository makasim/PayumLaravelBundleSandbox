<?php

use Payum\LaravelPackage\Controller\PayumController;

class PaypalController extends PayumController
{
	public function prepareExpressCheckout()
	{
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
        $details['PAYMENTREQUEST_0_AMT'] = 1.23;
        $storage->update($details);

        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken('paypal_ec', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
	}

    public function prepareExpressCheckoutPlusEloquent()
    {
        $storage = $this->getPayum()->getStorage('Payum\LaravelPackage\Model\Payment');

        /** @var \Payum\LaravelPackage\Model\Payment $payment */
        $payment = $storage->create();
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount(123);
        $storage->update($payment);

        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken('paypal_ec', $payment, 'payment_done_order');

        return \Redirect::to($captureToken->getTargetUrl());
    }

    public function prepareExpressCheckoutStoredInDatabase()
    {
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
        $details['PAYMENTREQUEST_0_AMT'] = 1.23;
        $storage->update($details);

        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken('paypal_ec_stored_in_database', $details, 'payment_done_order');

        return \Redirect::to($captureToken->getTargetUrl());
    }
}
