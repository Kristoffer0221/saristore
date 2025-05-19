@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
  <h1 class="text-3xl font-bold text-orange-600 mb-6">🛒 Your Cart</h1>

  @if(count($cart) > 0)
    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
      <thead class="bg-orange-100 text-orange-800">
        <tr>
          <th class="p-4 text-left">Item</th>
          <th class="p-4">Price</th>
          <th class="p-4">Quantity</th>
          <th class="p-4">Total</th>
          <th class="p-4">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cart as $id => $item)
        <tr class="border-b hover:bg-yellow-50">
          <td class="p-4 flex items-center gap-4">
            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
            <span>{{ $item['name'] }}</span>
          </td>
          <td class="p-4">₱{{ number_format($item['price'], 2) }}</td>
          <td class="p-4">
            <form action="{{ route('cart.add', $id) }}" method="POST" class="flex items-center gap-2">
              @csrf
              <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border rounded">
              <button type="submit" class="bg-orange-400 text-white px-2 py-1 rounded hover:bg-orange-500">Update</button>
            </form>
          </td>
          <td class="p-4">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
          <td class="p-4">
            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">🗑️ Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="text-right mt-1 text-gray-600 text-sm">
        (Approx. ${{ number_format($total / 56, 2) }} USD)
    </div>

    <div class="text-right mt-4">
      <!-- PAYPAL CHECKOUT BUTTON USING GET LINK -->
      <a href="{{ route('cart.checkout') }}" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
        💳 Checkout with PayPal
      </a>
    </div>

  @else
    <p class="text-gray-600 text-center text-lg mt-10">Your cart is empty 😢</p>
  @endif
</div>
@endsection
