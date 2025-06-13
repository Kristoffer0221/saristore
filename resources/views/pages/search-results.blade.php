@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="mb-8 bg-white p-6 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-gray-800">
            Search Results
            <span class="text-orange-500">
                ({{ $products->count() }} {{ Str::plural('item', $products->count()) }})
            </span>
        </h1>
        <p class="mt-2 text-gray-600">
            Showing results for: <span class="font-medium text-orange-600">"{{ $query }}"</span>
        </p>
    </div>

    @if($products->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl shadow-md">
            <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">No products found</h2>
            <p class="text-gray-600 mb-6">Try adjusting your search to find what you're looking for.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Back to Home
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Product Image -->
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2 hover:text-orange-500 transition-colors">
                            {{ $product->name }}
                        </h2>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-orange-500 font-bold">₱{{ number_format($product->price, 2) }}</span>
                            @if($product->stock > 0)
                                <span class="text-green-500 text-sm">In Stock ({{ $product->stock }})</span>
                            @else
                                <span class="text-red-500 text-sm">Out of Stock</span>
                            @endif
                        </div>

                        <!-- Add to Cart Form -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600
                                           transition-colors duration-200 flex items-center justify-center space-x-2
                                           {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        
    @endif
</div>
@endsection
