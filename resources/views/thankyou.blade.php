
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-8">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <circle class="opacity-25" cx="24" cy="24" r="20" stroke-width="4"/>
                <path class="opacity-75" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M14 24l8 8 16-16"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            Thank you for your order!
        </h1>
        
        <p class="text-lg text-gray-600 mb-8">
            Your order has been successfully placed and is being processed.
        </p>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                View Orders
            </a>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection