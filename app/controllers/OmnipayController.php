<?php

use Payum\Core\Security\SensitiveValue;
use Payum\LaravelPackage\Controller\CaptureController;

class OmnipayController extends BaseController
{
	public function prepareStripe()
	{
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['amount'] = '10.00';
        $details['currency'] = 'USD';
        $details['card'] = new SensitiveValue(array(
            'number' => '4012888888881881', //end zero so will be accepted
            'cvv' => 123,
            'expiryMonth' => 6,
            'expiryYear' => 16,
            'firstName' => 'foo',
            'lastName' => 'bar',
        ));
        $storage->update($details);

        $captureToken = $this->getTokenFactory()->createCaptureToken('stripe_direct', $details, 'payment_done');

        $captureController = new CaptureController;
        return $captureController->doAction($captureToken);
	}

    public function prepareStripeObtainCreditCard()
    {
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['amount'] = '10.00';
        $details['currency'] = 'USD';
        $storage->update($details);

        $captureToken = $this->getTokenFactory()->createCaptureToken('stripe_direct', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
    }

    /**
     * @return \Payum\Core\Registry\RegistryInterface
     */
    protected function getPayum()
    {
        return \App::make('payum');
    }

    /**
     * @return \Payum\Core\Security\GenericTokenFactoryInterface
     */
    protected function getTokenFactory()
    {
        return \App::make('payum.security.token_factory');
    }
}
