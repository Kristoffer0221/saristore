
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h1>

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="flash-message">
            {{ session('error') }}
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

    <form action="{{ route('checkout.placeOrder') }}" method="POST" class="bg-white border rounded-lg shadow-sm p-6">
        @csrf
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
                    <span>₱{{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Shipping Fee</span>
                    <span>₱{{ number_format($shipping = 125, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Discount</span>
                    <span>-₱{{ number_format($discount = 10, 2) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold text-gray-800 pt-3 border-t">
                    <span>Total</span>
                    <span>₱{{ number_format($total + $shipping - $discount, 2) }}</span>
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
</div>

<script>
    // Flash message auto-dismiss
    setTimeout(() => {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 2000);
</script>
@endsection