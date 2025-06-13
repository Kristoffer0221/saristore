@extends('layouts.app')

@section('content')

{{-- Alert Messages --}}
@if(session('success'))
    <div id="flash-message" class="fixed bottom-4 right-4 z-50 transform transition-all duration-300 ease-in-out" 
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-8"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-8">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 flex items-center shadow-lg rounded-lg">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 font-medium">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" class="inline-flex text-green-500 hover:text-green-600 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="flash-message" class="fixed bottom-4 right-4 z-50 transform transition-all duration-300 ease-in-out"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-8"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-8">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 flex items-center shadow-lg rounded-lg">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">
                    {{ session('error') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" class="inline-flex text-red-500 hover:text-red-600 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- CATEGORY HEADER IMAGE -->
    <div class="w-full rounded-xl overflow-hidden mb-6">
    <img src="{{ asset('storage/banners/snacks-banner.webp') }}" alt="Health & Beauty Banner" class="w-full h-[100px] object-fill">

    </div>

    <!-- FILTER BAR -->
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Drinks</h2>
        <div class="flex gap-2">

            @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('products.create') }}"
                   class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700 transition">
                    ➕ Add Product
                </a>
            @endif
            @endauth
            
            <button class="filter-btn px-4 py-1 bg-gray-200 text-sm rounded hover:bg-gray-300" data-sort="default">Default</button>
            <button class="filter-btn px-4 py-1 bg-gray-200 text-sm rounded hover:bg-gray-300" data-sort="low">Price Low</button>
            <button class="filter-btn px-4 py-1 bg-gray-200 text-sm rounded hover:bg-gray-300" data-sort="high">Price High</button>
        </div>
    </div>

    <!-- PRODUCT LIST -->
    <div id="product-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach ($products as $product)
            <div class="product-card bg-white rounded-xl shadow border p-4 hover:shadow-md transition" data-price="{{ $product->price }}">
                <!-- Product Image -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-contain mb-2">
                
                <!-- Product Details -->
                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-base font-bold text-orange-500 mt-1">₱{{ number_format($product->price, 2) }}</p>
                
                <!-- Stock Status -->
                <div class="mt-2 mb-3">
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
                    @if(auth()->user()->is_admin)
                        <!-- Admin Controls -->
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="w-full mb-2 inline-block text-center bg-blue-600 text-white text-sm py-1.5 rounded hover:bg-blue-700 transition">
                            ✏️ Edit Product
                        </a>

                        <form action="{{ route('products.destroy', $product->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this product?');" 
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white text-sm py-1.5 rounded hover:bg-red-700 transition">
                                🗑️ Delete
                            </button>
                        </form>
                    @else
                        <!-- User Controls -->
                        <div class="mt-3 grid grid-cols-2 gap-2">
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
                    @endif
                @else
                    <!-- Guest Controls -->
                    <div class="mt-3">
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition">
                            Login to Purchase
                        </a>
                    </div>
                @endauth

            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links('vendor.pagination.tailwind') }}
    </div>
</div>

<!-- SORTING SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".filter-btn");
        const productList = document.getElementById("product-list");

        buttons.forEach(button => {
            button.addEventListener("click", () => {
                const sortType = button.getAttribute("data-sort");
                const products = Array.from(productList.children);

                products.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute("data-price"));
                    const priceB = parseFloat(b.getAttribute("data-price"));

                    if (sortType === "low") return priceA - priceB;
                    if (sortType === "high") return priceB - priceA;
                    return 0; // default
                });

                productList.innerHTML = "";
                products.forEach(p => productList.appendChild(p));
            });
        });
    });

    window.onload = function() {
        // CHECK IF FLASH MESSAGE EXISTS
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            // SET A TIMER TO REMOVE THE MESSAGE AFTER 5 SECONDS (5000 MS)
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 5000); // YOU CAN CHANGE THE TIME (5000 MS = 5 SECONDS)
        }
    }
</script>
@endsection



