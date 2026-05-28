<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use InvalidArgumentException;

class PaymentService
{
    public function __construct(
        private GatewayManagerService $gatewayManager
    ) {}

    /*
    *    Process the donation and expects a gateway as argument
    *    @param array $request
    *    @return array<string, mixed>
    */
    public function donate(array $request): array
    {
        $gateway = $this->returnGateway($request['gateway']);
        $preference = $gateway->createPaymentPreference($request);
        return $preference;
    }

    /*
    *    Returns the gateway by name
    *    @return object|array<string, mixed>
    */
    public function returnGateway(?string $gatewayName): PaymentGatewayInterface
    {
        $gateway = $this->gatewayManager->findGateway($gatewayName);
        return $gateway;
    }
}