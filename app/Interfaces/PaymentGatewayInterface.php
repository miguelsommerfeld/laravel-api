<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function donate();
    public function refund();
    public function cancelPayment();
}
