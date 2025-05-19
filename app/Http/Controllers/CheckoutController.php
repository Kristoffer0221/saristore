<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        try {
            $request->validate([
                'payment_method' => 'required|in:cod,paypal'
            ]);

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return back()->with('error', 'Cart is empty');
            }

            $total = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => auth()->user()->address,
                'phone' => auth()->user()->phone,
                'status' => 'Order Placed'
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            session()->forget('cart');

            if ($request->payment_method === 'cod') {
                return redirect()->route('thankyou')->with('success', 'Order placed successfully! Thank you for choosing Cash on Delivery.');
            } else if ($request->payment_method === 'paypal') {
                session()->put('pending_order_id', $order->id);
                return redirect()->route('paypal.pay');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function handlePayPalReturn(Request $request)
    {
        $orderId = session()->get('pending_order_id');
        $order = Order::findOrFail($orderId);
        
        // You can verify payment here if needed
        $order->payment_status = 'paid';
        $order->save();

        session()->forget('pending_order_id');
        return redirect()->route('thankyou')->with('success', 'Payment completed successfully!');
    }

    public function handlePayPalCancel()
    {
        $orderId = session()->get('pending_order_id');
        $order = Order::findOrFail($orderId);
        
        $order->payment_status = 'failed';
        $order->save();

        session()->forget('pending_order_id');
        return redirect()->route('checkout')->with('error', 'Payment was cancelled.');
    }
}
