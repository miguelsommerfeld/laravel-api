<?php
declare(strict_types=1);

namespace App\Services\Gateways;

use App\Interfaces\PaymentGatewayInterface;
use App\Exceptions\InvalidPaymentGatewayException;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoService implements PaymentGatewayInterface
{
    public function __construct(private PreferenceClient $client)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    public function createRequestPreference(array $request): array
    {
        $paymentMethods = [
            'excluded_payment_methods' => [], // Payment methods that we won't use
            'installments'             => $request['installments'],
            'default_installments'     => 1
        ];

        $backUrls = [
            'success' => url('https://music.youtube.com/'),
            'failure' => url('https://music.youtube.com/'),
        ];

        // Transposing the request to a MercadoPago request
        $mercadoPagoRequest = [
            'items'                => [$request['donation']],
            'payment_methods'      => $paymentMethods,
            'back_urls'            => $backUrls,
            'payer'                => $request['email'],
            'statement_descriptor' => 'TESTE_TESTE_TESTE',
            'expires'              => false,
            'auto_return'          => 'approved'
        ];

        return $mercadoPagoRequest;
    }

    public function createPaymentPreference(array $request): array
    {
        $donation = [
            'title'       => 'DONATION',
            'description' => 'Make us grow and help us with a donation!',
            'currency_id' => $request['currency_id'],
            'unit_price'  => $request['donation_amount'],
            'quantity'    => 1
        ];

        $mercadoPagoRequest = $this->createRequestPreference([
            'donation'     => $donation,
            'installments' => $request['installments'],
            'email'        => $request['email'],
        ]);

        try {
            $preference = $this->client->create($mercadoPagoRequest);
            
            return [
                'data'   => $preference,
                'status' => 201
            ];
        } catch (MPApiException $error) {
            if ($error->getStatusCode() === 400) {
                throw new InvalidPaymentGatewayException(400, "Certifique-se de que os dados estão preenchidos corretamente.");
            }

            throw new InvalidPaymentGatewayException($error->getStatusCode(), $error->getApiResponse()->getContent()['message']);
        }
    }
}