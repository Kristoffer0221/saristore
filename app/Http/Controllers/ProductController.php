<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function showByCategory($category)
    {
        $products = Product::where('category', $category)->get();
        return view("pages.$category", compact('products'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', '✅ "' . $product->name . '" added to cart!');
    }

    public function create()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        return view('admin.products.create');
    }


    public function store(Request $request)
    {

        if (!auth()->user()->is_admin) {
            abort(403);
        }
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|in:snacks,drinks,canned,noodles,toiletries,household,school,pasabuy', // Add more categories as needed
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('products', 'public');

        // Create new product
        \App\Models\Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'category' => $request->input('category'),
        ]);

        return redirect()->route('products.create')->with('success', 'Product added successfully!');
    }



}
