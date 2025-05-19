@extends('layouts.app')

@section('content')
<div class="mx-auto my-6 max-w-3xl p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-center mb-4">Edit Product</h2>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Product Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Price</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full p-2 border rounded" step="0.01" min="1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Current Image</label><br>
            <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover mb-2">
            <input type="file" name="image" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Category</label>
            <select name="category" class="w-full p-2 border rounded" required>
                @foreach(['snacks', 'drinks', 'canned', 'noodles', 'toiletries', 'household', 'school', 'pasabuy'] as $category)
                    <option value="{{ $category }}" @if($product->category == $category) selected @endif>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Update Product</button>
        </div>
    </form>
</div>
@endsection
