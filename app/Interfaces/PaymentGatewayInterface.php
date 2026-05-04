<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function sendPayment(Request $request): array;
    public function callBack(Request $request): bool;
}
