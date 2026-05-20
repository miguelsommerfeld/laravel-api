<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;

class GatewayManagerService
{
    public function findGateway(string $gatewayName): PaymentGatewayInterface|\InvalidArgumentException
    {
        return match($gatewayName) {
            // 'mercadopago' => ,
            default       => new \InvalidArgumentException('Gateway não encontrado.', 403)
        };
    }
}