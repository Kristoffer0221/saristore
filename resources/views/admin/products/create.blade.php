@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-center mb-4">Add a New Product</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
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
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Add Product</button>
        </div>
    </form>
</div>
@endsection
