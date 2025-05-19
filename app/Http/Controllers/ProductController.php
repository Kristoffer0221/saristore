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
        $products = Product::where('category', $category)
            ->latest()
            ->paginate(5); // Show 12 products per page
        return view("pages.$category", compact('products'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|in:snacks,drinks,canned,noodles,toiletries,household,school,pasabuy',
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->category = $request->input('category');

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
            'category' => 'required|string|in:snacks,drinks,canned,noodles,toiletries,household,school,pasabuy',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'category' => $request->input('category'),
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




}
