<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function add(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $quantity = (int) $request->input('quantity', 1);
              
            // 1. UPDATE SESSION CART
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                ];
            }
            session()->put('cart', $cart);
    
            // 2. SAVE TO DATABASE IF LOGGED IN
            if (Auth::check()) {
                $userId = Auth::id();
    
                $existing = Cart::where('user_id', $userId)
                                ->where('product_id', $id)
                                ->first();
    
                if ($existing) {
                    $existing->quantity += $quantity;
                    $existing->save();
                } else {
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $id,
                        'quantity' => $quantity,
                    ]);
                }
            } else {
            }
    
            return redirect()->back()->with('success', '✅ "' . $product->name . '" added to cart!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Failed to add item to cart.');
        }
    }

    // Show cart contents
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // Remove product from the cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Item not found'], 404);
    }

    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        // Store buy now item in session
        $buyNowItem = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
        ];

        session()->put('buy_now_item', $buyNowItem);

        return redirect()->route('checkout.index', ['buy_now' => 'true']);
    }

    public function checkout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        
        if (empty($selectedItems)) {
            return back()->with('error', 'Please select items to checkout');
        }

        $cart = session()->get('cart', []);
        $checkoutItems = [];
        $total = 0;

        // Filter only selected items
        foreach ($cart as $id => $item) {
            if (in_array((string)$id, $selectedItems)) { // Convert to string for comparison
                $checkoutItems[$id] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        if (empty($checkoutItems)) {
            return back()->with('error', 'Selected items not found in cart');
        }

        // Store selected items and total for checkout
        session()->put('checkout_items', $checkoutItems);
        session()->put('checkout_total', $total);
        session()->put('selected_items', $selectedItems);

        return redirect()->route('checkout.index', ['selected_checkout' => true]);
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            $quantity = (int) $request->input('quantity');
            
            if ($quantity < 1) {
                return response()->json([
                    'error' => 'Quantity must be at least 1'
                ], 400);
            }

            $cart = session()->get('cart', []);
            
            if (!isset($cart[$id])) {
                return response()->json([
                    'error' => 'Item not found in cart'
                ], 404);
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'newTotal' => $cart[$id]['price'] * $quantity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error occurred'
            ], 500);
        }
    }
}
