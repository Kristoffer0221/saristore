@extends('layouts.app')

@section('content')
<!-- Hero Section with Search -->
<div class="bg-gradient-to-r from-orange-50 to-orange-100">
    <div class="max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Tindahan ni Aling Nena</h1>
            <p class="text-xl text-gray-600 mb-8">Your Neighborhood Store, Now Online!</p>
            
            <!-- Category Quick Links -->
            <div class="flex flex-wrap justify-center gap-4 mt-8">
                @foreach(['snacks', 'drinks', 'canned', 'noodles', 'toiletries', 'household', 'school', 'pasabuy'] as $category)
                    <a href="{{ route($category) }}" 
                       class="px-4 py-2 bg-white rounded-full shadow-sm hover:shadow-md transition-all transform hover:scale-105
                              text-gray-700 hover:text-orange-600 capitalize">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Main Content with Sidebar Layout -->
<div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Filter Sidebar -->
        <div class="md:w-64 flex-shrink-0">
            <div class="sticky top-20">
                <form action="{{ route('home') }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">All Categories</option>
                            @foreach(['snacks', 'drinks', 'canned', 'noodles', 'toiletries', 'household', 'school', 'pasabuy'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <label for="price_range" class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <select name="price_range" id="price_range" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">All Prices</option>
                            <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>Under ₱50</option>
                            <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>₱50 - ₱100</option>
                            <option value="100-200" {{ request('price_range') == '100-200' ? 'selected' : '' }}>₱100 - ₱200</option>
                            <option value="200+" {{ request('price_range') == '200+' ? 'selected' : '' }}>Over ₱200</option>
                        </select>
                    </div>

                    <!-- Sort By Filter -->
                    <div class="mb-6">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" id="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        </select>
                    </div>

                    <!-- Apply Filters Button -->
                    <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 transition-colors">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Section -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Latest Products</h2>
                    <p class="text-gray-600 mt-1">Check out our newest additions</p>
                </div>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-200">
                    View All
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div class="relative pb-[100%] overflow-hidden rounded-t-xl">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="absolute inset-0 w-full h-full object-cover ">
                                @if($product->stock < 1)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        Out of Stock
                                    </div>
                                @else
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        In Stock: {{ $product->stock }}
                                    </div>
                                @endif
                                <div class="absolute bottom-2 left-2">
                                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst($product->category) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1 truncate">{{ $product->description }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-lg font-bold text-orange-600">₱{{ number_format($product->price, 2) }}</span>
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="flex items-center bg-orange-100 text-orange-600 px-3 py-2 rounded-lg hover:bg-orange-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Add
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
