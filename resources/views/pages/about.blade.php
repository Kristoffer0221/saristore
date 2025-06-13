@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-sm p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Why Choose Us</h1>
        <p class="text-center text-gray-600 mb-12">Experience the best shopping with Tindahan ni Aling Nena</p>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-4 gap-6 mb-12">
            @foreach($sections as $section)
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="{{ $section->icon }} text-2xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-center mb-2">{{ $section->title }}</h3>
                <p class="text-gray-600 text-center">{{ $section->description }}</p>
            </div>
            @endforeach
        </div>

        @if(auth()->check() && auth()->user()->is_admin)
        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.sections.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 mr-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Section
            </a>
            <a href="{{ route('admin.sections.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Manage Sections
            </a>
        </div>
        @endif
    </div>
</div>
@endsection