<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    /*
    *  Creates a request for the payment gateway and expects a request body
    * @param array $request
    *  @return array
    */
    public function createRequestPreference(array $request): array;

    /*
    *  Creates a payment preference for the payment gateway
    * @param array $request
    *  @return array
    */
    public function createPaymentPreference(array $request): array;
}
