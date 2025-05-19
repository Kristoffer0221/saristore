@extends('layouts.app')

@section('content')

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
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-contain mb-2">
                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-base font-bold text-orange-500 mt-1">₱{{ number_format($product->price, 2) }}</p>

                @auth
                    @if(auth()->user()->is_admin)
                        <!-- EDIT BUTTON FOR ADMIN -->
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="w-full mb-2 inline-block text-center bg-blue-600 text-white text-sm py-1.5 rounded hover:bg-blue-700 transition">
                            ✏️ Edit Product
                        </a>

                        <!-- DELETE BUTTON -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white text-sm py-1.5 rounded hover:bg-red-700 transition">
                                🗑️ Delete
                            </button>
                        </form>
                    @else
                        <!-- ADD TO CART BUTTON FOR NORMAL USERS -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition">
                                Add to Cart 🛒
                            </button>
                        </form>
                    @endif
                @else
                    <!-- GUESTS SEE ADD TO CART -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition">
                            Add to Cart 🛒
                        </button>
                    </form>
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



