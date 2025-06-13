@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-gradient-to-b from-orange-50 to-white rounded-xl shadow-lg p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Add New Section</h2>
            <p class="text-gray-600">Create a new section for the about page</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 text-red-800 p-4 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.sections.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="page_name" value="about">
            <input type="hidden" name="section_name" value="{{ str_replace(' ', '_', strtolower(old('title', ''))) }}">
            
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                       required
                       onchange="document.getElementsByName('section_name')[0].value = this.value.toLowerCase().replace(/ /g, '_')">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" 
                          rows="4"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                          required>{{ old('description') }}</textarea>
            </div>

            <!-- Icon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                        <i class="fas fa-icons"></i>
                    </span>
                    <input type="text" 
                           name="icon" 
                           value="{{ old('icon', 'fas fa-') }}"
                           class="flex-1 min-w-0 block w-full rounded-none rounded-r-md border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                           required>
                </div>
                <p class="mt-1 text-sm text-gray-500">Use Font Awesome classes (e.g., fas fa-star)</p>
            </div>

            <!-- Order -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" 
                       name="order" 
                       value="{{ old('order', 0) }}"
                       class="w-32 rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                       min="0"
                       required>
            </div>

            <!-- Active Status -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.sections.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Create Section
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection