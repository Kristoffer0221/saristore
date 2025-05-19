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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $userId = Auth::id();

        // REMOVE FROM DATABASE CART
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $id)
                        ->first();

        if ($cartItem) {
            $cartItem->delete();
        } else {
        }

        // REMOVE FROM SESSION CART
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', '🗑️ Item removed from cart.');
    }

}
