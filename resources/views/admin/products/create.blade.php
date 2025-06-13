@extends('layouts.app')

@section('content')



<div class="mx-auto my-6 max-w-3xl max-h-120 p-6 bg-white rounded-lg shadow-md  ">

    <h2 class="text-3xl font-bold text-center mb-4">Add a New Product</h2>

   {{-- ALERT MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success mb-4 p-3 bg-green-200 text-green-800 rounded" id="flash-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4 p-3 bg-red-200 text-green-800 rounded" id="flash-message">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Product Name</label>
            <input type="text" id="name" name="name" class="w-full p-2 border rounded" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Product Price -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price</label>
            <input type="number" id="price" name="price" class="w-full p-2 border rounded" step="0.01" min="1" required>
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <label for="stock" class="block text-gray-700 font-medium mb-2">Stock Quantity</label>
            <div class="relative rounded-md shadow-sm">
                <input type="number" 
                       id="stock" 
                       name="stock" 
                       class="w-full p-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500" 
                       min="0" 
                       value="{{ old('stock', 0) }}" 
                       required>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Enter the available quantity for this product</p>
        </div>

        <!-- Product Image -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Product Image</label>
            <input type="file" id="image" name="image" class="w-full p-2 border rounded" required>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700">Category</label>
            <select id="category" name="category" class="w-full p-2 border rounded" required>
                <option value="snacks">Snacks</option>
                <option value="drinks">Drinks</option>
                <option value="canned">Canned Goods</option>
                <option value="noodles">Noodles</option>
                <option value="toiletries">Toiletries</option>
                <option value="household">Household</option>
                <option value="school">School Supplies</option>
                <option value="pasabuy">Pasabuy</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Add Product</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Add client-side validation for stock
    document.getElementById('stock').addEventListener('input', function(e) {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    window.onload = function() {
        // CHECK IF FLASH MESSAGE EXISTS
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            // SET A TIMER TO REMOVE THE MESSAGE AFTER 5 SECONDS (5000 MS)
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 3000); // YOU CAN CHANGE THE TIME (5000 MS = 5 SECONDS)
        }
    }
</script>
@endsection
