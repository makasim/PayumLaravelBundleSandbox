<?php

use Payum\LaravelPackage\Controller\PayumController;

class StripeController extends PayumController
{
	public function prepareJs()
	{
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['amount'] = '100';
        $details['currency'] = 'USD';
        $details['description'] = 'a desc';
        $storage->update($details);

        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken('stripe_js', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
	}

    public function prepareCheckout()
    {
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['amount'] = '100';
        $details['currency'] = 'USD';
        $details['description'] = 'a desc';
        $storage->update($details);

        $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken('stripe_checkout', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
    }
}
