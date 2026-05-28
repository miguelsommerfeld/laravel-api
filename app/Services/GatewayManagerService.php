<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Services\Gateways\MercadoPagoService;
use App\Exceptions\InvalidPaymentGatewayException;

class GatewayManagerService
{
    public function findGateway(string $gatewayName): PaymentGatewayInterface|InvalidPaymentGatewayException
    {
        return match($gatewayName) {
            'mercadopago' => app(MercadoPagoService::class),
            default       => throw new InvalidPaymentGatewayException(403, 'Gateway não encontrado.')
        };
    }
}