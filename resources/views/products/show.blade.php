@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-1/2">
                <div class="relative pb-[100%]">
                    <img class="absolute inset-0 w-full h-full object-contain p-4" 
                         src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         onerror="this.src='{{ asset('images/no-image.jpg') }}'">
                </div>
            </div>
            <div class="p-8 md:w-1/2">
                <div class="uppercase tracking-wide text-sm text-orange-500 font-semibold">
                    {{ ucfirst($product->category) }}
                </div>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-4 text-gray-600">{{ $product->description }}</p>
                
                <div class="mt-6">
                    <div class="text-3xl font-bold text-orange-600">₱{{ number_format($product->price, 2) }}</div>
                    <div class="mt-2 text-sm text-gray-500">
                        @if($product->stock > 0)
                            <span class="text-green-600">In Stock: {{ $product->stock }}</span>
                        @else
                            <span class="text-red-600">Out of Stock</span>
                        @endif
                    </div>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-8">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 
                                       flex items-center justify-center font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection