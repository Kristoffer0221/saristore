<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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

    public function createOrder(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $provider->getAccessToken();

        // Calculate total from cart items sent in the request
        $cart = $request->input('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($total, 2, '.', '')
                    ]
                ]
            ]
        ]);

        return response()->json($response);
    }

    public function captureOrder($orderId, Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($orderId);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Save order to DB
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => uniqid('ORD-'),
                'total_amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'payment_method' => 'paypal',
                'payment_status' => 'paid',
                'status' => 'Order Placed',
                'shipping_address' => '', // Fill as needed
                'phone' => '', // Fill as needed
            ]);
            // Optionally, save cart items to order_items table here

            // Clear cart session if needed
            session()->forget('cart');
        }

        return response()->json($response);
    }
}
