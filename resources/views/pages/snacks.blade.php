@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- CATEGORY HEADER IMAGE -->
    <div class="w-full rounded-xl overflow-hidden mb-6">
    <img src="{{ asset('storage/banners/snacks-banner.webp') }}" alt="Health & Beauty Banner" class="w-full h-[100px] object-fill">

    </div>

    <!-- FILTER BAR -->
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Merienda Snacks</h2>
        <div class="flex gap-2">
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

                <!-- ADD TO CART BUTTON -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-orange-500 text-white text-sm py-1.5 rounded hover:bg-orange-600 transition">
                        Add to Cart 🛒
                    </button>
                </form>
            </div>
        @endforeach
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
</script>
@endsection



