@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-yellow-800 mb-6">📦 ALL PRODUCTS - TINDAHAN NI ALING NENA</h1>
    
        <a href="{{ route('products.create') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition">
            ➕ Add New Product
        </a>
    

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 animate-bounce-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg max-h-96 overflow-y-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-yellow-300 text-yellow-900 uppercase text-xs sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-3">📌 Name</th>
                    <th class="px-6 py-3">💸 Price</th>
                    <th class="px-6 py-3">📂 Category</th>
                    <th class="px-6 py-3 text-center">⚙️ Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="bg-yellow-50 border-b hover:bg-yellow-100 transition duration-150">
                        <td class="px-6 py-4 font-semibold">{{ $product->name }}</td>
                        <td class="px-6 py-4">₱{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 capitalize">{{ $product->category }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition">✏️ Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    

    <div class="mt-4">
        {{ $products->links('vendor.pagination.tailwind') }}
    </div>
    
</div>
@endsection
