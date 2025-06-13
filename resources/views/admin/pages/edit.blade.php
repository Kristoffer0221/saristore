@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-gradient-to-b from-orange-50 to-white rounded-xl shadow-lg p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Edit About Page</h2>
            <p class="text-gray-600">Make your about page content more engaging</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 text-green-800 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 text-red-800 p-4 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.update', 'about') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Page Title -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <label class="block text-lg font-medium text-gray-800 mb-4">Page Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $pageContent->title ?? '') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                       placeholder="Enter page title">
            </div>

            <!-- Main Story -->
            <div class="bg-orange-50 p-6 rounded-lg shadow-sm">
                <label class="block text-lg font-medium text-gray-800 mb-4">Our Story</label>
                <textarea id="mainContent" 
                          name="content" 
                          rows="6"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                          placeholder="Tell your story...">{{ old('content', $pageContent->content ?? '') }}</textarea>
            </div>

            <!-- Features -->
            <div class="bg-yellow-50 p-6 rounded-lg shadow-sm">
                <label class="block text-lg font-medium text-gray-800 mb-4">Features</label>
                <div id="features-container" class="space-y-3">
                    @forelse(old('features', $pageContent->features ?? []) as $feature)
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   name="features[]" 
                                   value="{{ $feature }}"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <button type="button" onclick="removeItem(this)" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @empty
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   name="features[]" 
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                   placeholder="Add a feature">
                        </div>
                    @endforelse
                </div>
                <button type="button" 
                        onclick="addItem('features-container', 'features[]')" 
                        class="mt-3 text-sm text-orange-600 hover:text-orange-700">
                    + Add Feature
                </button>
            </div>

            <!-- Contact Information -->
            <div class="bg-blue-50 p-6 rounded-lg shadow-sm">
                <label class="block text-lg font-medium text-gray-800 mb-4">Contact Information</label>
                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm text-gray-600">Phone Number</label>
                        <input type="text" 
                               name="contact[phone]" 
                               value="{{ old('contact.phone', $pageContent->contact->phone ?? '') }}"
                               class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Email</label>
                        <input type="email" 
                               name="contact[email]" 
                               value="{{ old('contact.email', $pageContent->contact->email ?? '') }}"
                               class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Operating Hours</label>
                        <textarea name="contact[hours]" 
                                  rows="3"
                                  class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('contact.hours', $pageContent->contact->hours ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('about') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function addItem(containerId, inputName) {
    const container = document.getElementById(containerId);
    const wrapper = document.createElement('div');
    wrapper.className = 'flex items-center gap-2';
    
    wrapper.innerHTML = `
        <input type="text" 
               name="${inputName}" 
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
               placeholder="Add item">
        <button type="button" onclick="removeItem(this)" class="text-red-500 hover:text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    
    container.appendChild(wrapper);
}

function removeItem(button) {
    button.closest('div').remove();
}

// Initialize TinyMCE for rich text editing
tinymce.init({
    selector: '#mainContent',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | \
             alignleft aligncenter alignright alignjustify | \
             bullist numlist outdent indent | removeformat | help'
});
</script>
@endpush
@endsection