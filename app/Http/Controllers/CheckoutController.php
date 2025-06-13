<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Check if it's a buy now request
        if ($request->has('buy_now')) {
            $buyNowItem = session()->get('buy_now_item');
            
            if (!$buyNowItem) {
                return redirect()->route('home')->with('error', 'Item not found');
            }

            return view('cart.checkout', [
                'cart' => [$buyNowItem['id'] => $buyNowItem],
                'total' => $buyNowItem['price'] * $buyNowItem['quantity'],
                'isBuyNow' => true
            ]);
        }

        // Handle selected items checkout
        if ($request->has('selected_checkout')) {
            $checkoutItems = session()->get('checkout_items', []);
            $total = session()->get('checkout_total', 0);

            if (empty($checkoutItems)) {
                return redirect()->route('cart.index')->with('error', 'No items selected for checkout');
            }

            return view('cart.checkout', [
                'cart' => $checkoutItems,
                'total' => $total,
                'isBuyNow' => false
            ]);
        }

        // Get regular cart items if no special checkout type
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.checkout', [
            'cart' => $cart,
            'total' => $total,
            'isBuyNow' => false
        ]);
    }

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $checkoutItems = session()->get('checkout_items', []);
            $total = session()->get('checkout_total', 0);

            if (empty($checkoutItems)) {
                return back()->with('error', 'No items selected for checkout');
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => auth()->user()->address,
                'phone' => auth()->user()->phone,
                'status' => 'pending'
            ]);

            $cart = session()->get('cart', []);

            // Create order items and update stock
            foreach ($checkoutItems as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Update product stock
                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }

                // Remove item from cart
                unset($cart[$id]);
            }

            // Update cart session
            session()->put('cart', $cart);
            
            // Clear checkout sessions
            session()->forget(['checkout_items', 'checkout_total', 'selected_items']);

            DB::commit();

            if ($request->payment_method === 'paypal') {
                session()->put('pending_order_id', $order->id);
                return redirect()->route('paypal.pay');
            }

            return redirect()->route('thankyou')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order processing error: ' . $e->getMessage());
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

    public function processBuyNow(Request $request)
    {
        
        try {
            $buyNowItem = session()->get('buy_now_item');
            
            if (!$buyNowItem) {
                return redirect()->route('home')->with('error', 'Item not found');
            }

            // Check stock availability
            $product = Product::find($buyNowItem['id']);
            if (!$product || $product->stock < $buyNowItem['quantity']) {
                throw new \Exception('Product is out of stock');
            }

            // Calculate total
            $total = $buyNowItem['price'] * $buyNowItem['quantity'];

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => Order::PAYMENT_PENDING,
                'status' => 'pending',
                'shipping_address' => auth()->user()->address,
                'phone' => auth()->user()->phone,
                'notes' => $request->notes ?? null
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $buyNowItem['id'],
                'quantity' => $buyNowItem['quantity'],
                'price' => $buyNowItem['price']
            ]);

            // Update product stock
            $product->decrement('stock', $buyNowItem['quantity']);

            // Clear buy now session
            session()->forget('buy_now_item');

            

            if ($request->payment_method === 'paypal') {
                return redirect()->route('paypal.pay', ['order_id' => $order->id]);
            }

            return redirect()->route('thankyou')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
        
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
