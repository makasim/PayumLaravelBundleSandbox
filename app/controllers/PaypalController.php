<?php

class PaypalController extends BaseController
{
	public function prepareExpressCheckout()
	{
        $storage = $this->getPayum()->getStorage('Payum\Core\Model\ArrayObject');

        $details = $storage->create();
        $details['PAYMENTREQUEST_0_CURRENCYCODE'] = 'EUR';
        $details['PAYMENTREQUEST_0_AMT'] = 1.23;
        $storage->update($details);

        $captureToken = $this->getTokenFactory()->createCaptureToken('paypal_ec', $details, 'payment_done');

        return \Redirect::to($captureToken->getTargetUrl());
	}

    public function prepareExpressCheckoutPlusEloquent()
    {
        $storage = $this->getPayum()->getStorage('Payum\LaravelPackage\Model\Order');

        /** @var \Payum\LaravelPackage\Model\Order $order */
        $order = $storage->create();
        $order->setCurrencyCode('EUR');
        $order->setTotalAmount(1.23);
        $storage->update($order);

        $captureToken = $this->getTokenFactory()->createCaptureToken('paypal_ec_plus_eloquent', $order, 'payment_done_order');

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
