<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\DonationModel;

class PaymentService
{
    public function __construct(
        private GatewayManagerService $gatewayManager,
        private DonationModel $donationModel,
        private UserService $userService
    ) {}

    /**
    * Process the donation and expects a gateway as argument
    * @param array $request
    * @return array<string, mixed>
    */
    public function donate(array $request): array
    {
        $gateway = $this->returnGateway($request['gateway']);

        $preference = $gateway->createPaymentPreference($request);

        $this->storeDonationData($preference['data']->id, $preference['data']->items[0]->unit_price, $preference['data']->payer->email);
        return $preference;
    }

    /**
    * Returns the gateway by name
    * @return object|array<string, mixed>
    */
    public function returnGateway(?string $gatewayName): PaymentGatewayInterface
    {
        $gateway = $this->gatewayManager->findGateway($gatewayName);
        return $gateway;
    }

    public function storeDonationData(string $idDonation, float $price, string $payerEmail): void
    {
        $donationData = [
            'id_donation' => $idDonation,
            'amount'      => $price,
            'status'      => 'pending',
            'created_at'  => now(),
            'user_id'     => $this->userService->returnUserId($payerEmail)
        ];
        
        $this->donationModel->create($donationData);
    }

    public function updateDonationStatus(string $idDonation, string $status): void
    {
        $this->donationModel->where('id_donation', $idDonation)->update(['status' => $status]);
    }
}