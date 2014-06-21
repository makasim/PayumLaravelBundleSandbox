<?php

class PaymentController extends BaseController
{
	public function examples()
	{
		return View::make('payment_examples');
	}

    public function done()
    {
        return View::make('payment_done');
    }
}
