<?php

class StripeController extends BaseController
{
	public function prepareJs()
	{
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->createModel();
        $details['amount'] = '100';
        $details['currency'] = 'USD';
        $details['description'] = 'a desc';
        $storage->updateModel($details);

        $captureToken = $this->getTokenFactory()->createCaptureToken('stripe_js', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
	}

    public function prepareCheckout()
    {
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->createModel();
        $details['amount'] = '100';
        $details['currency'] = 'USD';
        $details['description'] = 'a desc';
        $storage->updateModel($details);

        $captureToken = $this->getTokenFactory()->createCaptureToken('stripe_checkout', $details, 'payment_done');

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
