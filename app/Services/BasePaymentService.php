<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class BasePaymentService
{
    protected $base_url;
    protected array $header;

    protected function buildRequest($method, $url, $data = null, $type = 'json'): array
    {
        try {
            $http = Http::withHeaders($this->header);

            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            $response = $http->send($method, $this->base_url . $url, [
                $type => $data
            ]);

            return [
                'success' => $response->successful(),
                'status'  => $response->status(),
                'data'    => $response->json(),
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'status'  => 500,
                'data'    => null,
                'message' => $e->getMessage(),
            ];
        }
    }
}
