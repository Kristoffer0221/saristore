@extends('layouts.app') {{-- OR YOUR MAIN LAYOUT --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold mb-6 text-orange-500">🔍 Search results for: <span class="italic text-black">{{ $query }}</span></h1>

  @if($products->isEmpty())
    <div class="text-gray-600 text-lg">No products found.</div>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($products as $product)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
          <div class="p-4">
            <h2 class="text-lg font-semibold text-orange-500 mb-2">{{ $product->name }}</h2>
            <p class="text-gray-700 text-sm mb-3">₱{{ number_format($product->price, 2) }}</p>

            <form method="POST" action="{{ route('cart.add', $product->id) }}">
              @csrf
              <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600 text-sm font-semibold">
                🛒 Add to Cart
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
