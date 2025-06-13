@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h1>

    @if(empty($cart))
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Add some items to your cart to checkout</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition">
                Continue Shopping
            </a>
        </div>
    @else
        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
            <div id="flash-message" 
                 class="mb-6 p-4 rounded-lg {{ session('success') ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' }}">
                {{ session('success') ?? session('error') }}
            </div>
        @endif

        {{-- DELIVERY ADDRESS SECTION --}}
        <div class="bg-white border p-6 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">📍 Delivery Address</h2>
                <button class="text-orange-600 hover:text-orange-700 text-sm font-medium">Change</button>
            </div>
            <div class="bg-gray-50 p-4 rounded-md">
                <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-gray-600">{{ auth()->user()->phone }}</p>
                <p class="text-gray-600 mt-1">{{ auth()->user()->address }}</p>
            </div>
        </div>

        {{-- PRODUCTS ORDERED --}}
        <div class="bg-white border rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">🛒 Order Summary</h2>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-4 py-3 text-sm font-medium text-gray-600">Product</th>
                            <th class="text-center px-4 py-3 text-sm font-medium text-gray-600">Price</th>
                            <th class="text-center px-4 py-3 text-sm font-medium text-gray-600">Quantity</th>
                            <th class="text-right px-4 py-3 text-sm font-medium text-gray-600">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($cart as $id => $item)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-16 h-16 object-cover rounded-md border">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                                        @if(isset($item['variation']))
                                        <p class="text-sm text-gray-500">{{ $item['variation'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center text-gray-600">₱{{ number_format($item['price'], 2) }}</td>
                            <td class="px-4 py-4 text-center text-gray-600">{{ $item['quantity'] }}</td>
                            <td class="px-4 py-4 text-right font-medium text-gray-800">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CHECKOUT FORM --}}
        <form action="{{ $isBuyNow ? route('checkout.buyNow') : route('checkout.placeOrder') }}" method="POST" class="bg-white border rounded-lg shadow-sm p-6">
            @csrf
            <input type="hidden" name="is_buy_now" value="{{ $isBuyNow ? 'true' : 'false' }}">
            
            {{-- PAYMENT METHOD --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">💳 Payment Method</h2>
                <div class="space-y-3">
                    <label class="flex items-center p-4 border rounded-md cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="cod" checked class="h-4 w-4 text-orange-600">
                        <span class="ml-3 font-medium text-gray-700">Cash on Delivery</span>
                    </label>
                    <label class="flex items-center p-4 border rounded-md cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="paypal" class="h-4 w-4 text-orange-600">
                        <span class="ml-3 font-medium text-gray-700">PayPal</span>
                    </label>
                </div>
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="border-t pt-6">
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($total ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-xl font-bold text-gray-800 pt-3 border-t">
                        <span>Total</span>
                        <span>₱{{ number_format(($total ?? 0) , 2) }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-orange-600 text-white py-3 px-6 rounded-md font-medium hover:bg-orange-700 transition duration-200">
                        Place Order
                    </button>
                    <a href="{{ route('cart.index') }}" class="block text-center mt-4 text-gray-600 hover:text-gray-800">
                        ← Back to Cart
                    </a>
                </div>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flash message auto-dismiss
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => flashMessage.remove(), 500);
            }, 3000);
        }
    });
</script>
@endpush
@endsection