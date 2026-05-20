<?php
declare(strict_types=1);

namespace App\Services;

class PaymentService
{
    public function __construct(
        private GatewayManagerService $gatewayManager
    ) {}

    public function donate(mixed $gatewayName): array
    {
        if (!is_string($gatewayName)) {
            return [
                'message' => 'O parâmetro "gateway" deve ser do tipo String.',
                'status'  => 401
            ];
        }

        $gateway = $this->gatewayManager->findGateway($gatewayName);

        if ($gateway instanceof \InvalidArgumentException) {
            return [
                'message' => $gateway->getMessage(),
                'status'  => $gateway->getCode()
            ];
        }

        return [];
    }
}