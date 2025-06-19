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
                <div class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center">
                    <div class="w-full h-48 bg-white-100 flex items-center justify-center overflow-hidden rounded-lg mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain transition-transform duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 truncate mb-1">{{ $product->name }}</h3>
                    <p class="text-base font-bold text-orange-500 mt-1 mb-2">₱{{ number_format($product->price, 2) }}</p>
                    
                    <!-- Stock Status -->
                    <div class="mb-3 w-full">
                        @if($product->stock > 10)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                In Stock ({{ $product->stock }})
                            </span>
                        @elseif($product->stock > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Low Stock ({{ $product->stock }} left)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    @auth
                        <div class="mt-3 grid grid-cols-2 gap-2 w-full">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $product->stock > 0 ? '🛒 Add to Cart' : 'Out of Stock' }}
                                </button>
                            </form>
                            <form action="{{ route('buy.now', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-blue-600 text-white text-sm py-1.5 rounded hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $product->stock > 0 ? '⚡ Buy Now' : 'Out of Stock' }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 w-full">
                            <a href="{{ route('login') }}" 
                               class="block w-full text-center bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition">
                                Login to Purchase
                            </a>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>

        
    @endif
</div>
@endsection
