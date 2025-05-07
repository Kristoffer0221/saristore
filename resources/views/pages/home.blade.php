<!-- resources/views/home.blade.php -->

@extends('layouts.app') <!-- OR your base layout -->

@section('content')
    <section class="p-6 bg-gray-100">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">CATEGORIES</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">

        <!-- CATEGORY ITEM -->
        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/mens-apparel.png" alt="Men's Apparel" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Men's Apparel</p>
        </div>

        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/mobiles-gadgets.png" alt="Mobiles & Gadgets" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Mobiles & Gadgets</p>
        </div>

        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/mobile-accessories.png" alt="Mobiles Accessories" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Mobiles Accessories</p>
        </div>

        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/home-entertainment.png" alt="Home Entertainment" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Home Entertainment</p>
        </div>

        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/babies-kids.png" alt="Babies & Kids" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Babies & Kids</p>
        </div>

        <div class="flex flex-col items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <img src="/images/categories/home-living.png" alt="Home & Living" class="mb-2 w-16 h-16 object-contain">
        <p class="text-center text-sm font-medium text-gray-700">Home & Living</p>
        </div>

        <!-- Continue adding the remaining categories -->

    </div>
    </section>
@endsection
