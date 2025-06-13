@extends('layouts.app')

@section('content')
<div class="mx-auto my-6 max-w-3xl p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-center mb-4">Edit Product</h2>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block text-gray-700">Product Name</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border rounded" required>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label class="block text-gray-700">Price</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full p-2 border rounded" step="0.01" min="1" required>
        </div>

        <!-- Stock Management -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Stock Management</label>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="mr-4">
                        <span class="text-sm font-medium text-gray-500">Current Stock:</span>
                        <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $product->stock }} units
                        </span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Status:</span>
                        <span class="ml-2 text-sm">
                            @if($product->stock > 10)
                                <span class="text-green-600">✓ Well Stocked</span>
                            @elseif($product->stock > 0)
                                <span class="text-yellow-600">⚠ Low Stock</span>
                            @else
                                <span class="text-red-600">✕ Out of Stock</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Update Stock Quantity</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $product->stock) }}" 
                                   class="w-full p-2 border rounded-lg focus:ring-orange-500 focus:border-orange-500" 
                                   min="0" 
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label class="block text-gray-700">Current Image</label><br>
            <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover mb-2">
            <input type="file" name="image" class="w-full p-2 border rounded">
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-gray-700">Category</label>
            <select name="category" class="w-full p-2 border rounded" required>
                @foreach(['snacks', 'drinks', 'canned', 'noodles', 'toiletries', 'household', 'school', 'pasabuy'] as $category)
                    <option value="{{ $category }}" @if($product->category == $category) selected @endif>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center space-x-4">
            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Update Product
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('stock').addEventListener('input', function(e) {
    if (this.value < 0) {
        this.value = 0;
    }
});
</script>
@endsection
