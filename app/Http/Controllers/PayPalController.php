<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;

class PayPalController extends Controller
{
    public function payWithPayPal()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $paypalToken = $provider->getAccessToken();

        $orderId = session('pending_order_id');
        $order = Order::findOrFail($orderId);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('services.paypal.currency'),
                        "value" => $order->total_amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout')->with('error', 'Something went wrong with PayPal.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if ($response['status'] == 'COMPLETED') {
            $orderId = session('pending_order_id');
            $order = Order::findOrFail($orderId);
            $order->payment_status = 'paid';
            $order->save();
            session()->forget('pending_order_id');
            return redirect()->route('thankyou')->with('success', 'Payment successful!');
        }

        return redirect()->route('checkout')->with('error', 'Payment failed.');
    }

    public function cancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment was cancelled.');
    }
}
