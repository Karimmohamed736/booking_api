<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;

class PaymobPaymentService extends BasePaymentService implements PaymentGatewayInterface
{
    protected $api_key;

    protected $integration_id;

    public function __construct()
    {
        $this->base_url = config('services.paymob.base_url');
        $this->api_key = config('services.paymob.api_key');
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $this->integration_id = [5639227, 5638993]; // integration IDs for different payment methods
    }

    // Generate authentication token for Paymob API after validating the API key
    public function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);

        if (! $response['success'] || empty($response['data']['token'])) {
            throw new \Exception(
                'Paymob authentication failed: '.
                ($response['data']['message'] ?? $response['message'] ?? 'Unknown error').
                ' (Status: '.$response['status'].')'
            );
        }
        // dd($response);

        return $response['data']['token'];
    }

    public function sendPayment(Request $request): array
    {

        $this->header['Authorization'] = 'Bearer '.$this->generateToken();

        $data = $request->all();
        $data['integration_id'] = $this->integration_id;

        $response = $this->buildRequest('POST', '/api/ecommerce/orders', $data);

        // dd($response);

        if ($response['success']) {
            return [
                'success' => true,
                'url' => $response['data']['url'],
                'order_id' => $response['data']['id'],
                'data' => $response['data'],
                'raw_response' => $response,
                'request_data' => $data,
                'request_headers' => $this->header,
                'request_url' => $this->base_url.'/api/ecommerce/orders',
            ];
        } else {
            return [
                'success' => false,
                'message' => $response['data']['message'] ?? 'Payment initiation failed.',
            ];
        }
    }

    public function callBack(Request $request): bool
    {
        $request->validate([
            'success' => 'required|boolean',
        ]);

        $paymentStatus = $request->input('success');

        return $paymentStatus === 'true' || $paymentStatus === true;
    }
}
