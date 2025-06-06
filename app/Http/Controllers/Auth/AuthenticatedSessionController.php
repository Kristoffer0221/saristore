<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Cart;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    $request->session()->regenerate();

    $user = Auth::user();

    // ✅ IF NOT ADMIN, LOAD CART FROM DB INTO SESSION
    if (!$user->is_admin) {
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        $cartSession = [];
        foreach ($cartItems as $item) {
            $cartSession[$item->product_id] = [
                'name' => $item->product->name,
                'price' => $item->product->price,
                'image' => $item->product->image,
                'quantity' => $item->quantity,
            ];
        }

        session()->put('cart', $cartSession);
    }
    // ✅ REDIRECT BASED ON ROLE
    return redirect()->intended($user->is_admin ? route('admin.products.index') : route('cart.index'));
}


    
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('home');
    }
}
