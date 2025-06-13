<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function showByCategory($category)
    {
        if ($category === 'home') {
            $query = Product::query();

            // Apply category filter
            if (request()->filled('category')) {
                $query->where('category', request('category'));
            }

            // Apply price range filter
            if (request()->filled('price_range')) {
                $range = explode('-', request('price_range'));
                if (count($range) === 2) {
                    $query->whereBetween('price', [$range[0], $range[1]]);
                } elseif (request('price_range') === '200+') {
                    $query->where('price', '>=', 200);
                }
            }

            // Apply sorting
            switch (request('sort', 'latest')) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $latestProducts = $query->paginate(10)->through(function ($product) {
                $product->image_url = $product->getImageUrlAttribute();
                return $product;
            });

            $featuredProducts = Product::inRandomOrder()
                ->take(6)
                ->get()
                ->map(function ($product) {
                    $product->image_url = $product->getImageUrlAttribute();
                    return $product;
                });

            return view('pages.home', compact('latestProducts', 'featuredProducts'));
        }

        // Validate category
        $products = Product::where('category', $category)
            ->latest()
            ->paginate(5)
            ->through(function ($product) {
                $product->image_url = $product->getImageUrlAttribute();
                return $product;
            });

        return view("pages.$category", compact('products'));
    }

    public function show(Product $product)
    {
        $product->image_url = $product->getImageUrlAttribute();
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|in:snacks,drinks,canned,noodles,toiletries,household,school,pasabuy',
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->stock = $request->input('stock');

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($product->image);
            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.create')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // OPTIONAL: DELETE IMAGE FILE IF SAVED IN STORAGE
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|in:snacks,drinks,canned,noodles,toiletries,household,school,pasabuy',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'category' => $request->input('category'),
            'stock' => $request->input('stock'),
        ]);

        return redirect()->route('products.create')->with('success', 'Product added successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->get();

        return view('pages.search-results', compact('products', 'query'));
    }

    public function adminIndex()
    {
        $products = Product::latest()->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    public function user()
    {
        $users = User::where('is_admin', false)->get();
        $admins = User::where('is_admin', true)->get();
        return view('admin.products.users', compact('users', 'admins'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->is_admin = $request->is_admin;
        $user->save();

        return redirect()->route('admin.products.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.products.users')->with('success', 'User deleted successfully.');
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'address' => 'required',
            'phone' => 'required',
            'is_admin' => 'required|boolean'
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'is_admin' => $request->is_admin,
        ]);
    
        return redirect()->route('admin.products.users')->with('success', 'User created successfully..');
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'address' => 'required',
            'phone' => 'required',
            'is_admin' => 'required|boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'is_admin' => 1, // Admin
        ]);

        return redirect()->route('admin.products.users')->with('success', 'Admin created successfully..');
    }

    public function checkStock($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'in_stock' => $product->isInStock(),
            'stock_count' => $product->stock
        ]);
    }

    // Add a method to update stock
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->input('stock');
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully',
            'new_stock' => $product->stock
        ]);
    }

    // Add a method to handle low stock notifications
    public function getLowStockProducts()
    {
        $lowStockThreshold = 5; // You can adjust this value
        $lowStockProducts = Product::where('stock', '<=', $lowStockThreshold)
                                  ->where('stock', '>', 0)
                                  ->get();

        return view('admin.products.low-stock', compact('lowStockProducts'));
    }
}
