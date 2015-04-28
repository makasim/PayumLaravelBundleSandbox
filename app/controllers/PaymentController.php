<?php

use Payum\Core\Registry\RegistryInterface;
use Payum\Core\Request\SimpleStatusRequest;
use Payum\Core\Security\HttpRequestVerifierInterface;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends BaseController
{
	public function examples()
	{
		return \View::make('payment_examples');
	}

    public function done($payum_token)
    {
        /** @var Request $request */
        $request = \App::make('request');
        $request->attributes->set('payum_token', $payum_token);

        $token = $this->getHttpRequestVerifier()->verify($request);

        $status = new SimpleStatusRequest($token);
        $this->getPayum()->getPayment($token->getPaymentName())->execute($status);

        return \Response::json(array(
            'status' => $status->getStatus(),
            'details' => iterator_to_array($status->getModel())
        ));
    }

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return \App::make('payum');
    }

    /**
     * @return HttpRequestVerifierInterface
     */
    protected function getHttpRequestVerifier()
    {
        return \App::make('payum.security.http_request_verifier');
    }
}
