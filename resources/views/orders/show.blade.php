
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Order #{{ $order->id }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Placed on {{ $order->created_at->format('F d, Y h:ia') }}
                </p>
            </div>
            
            <!-- Order Details -->
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ ucfirst($order->payment_method) }}
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Order Items -->
            <div class="px-4 py-5 sm:px-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Items</h4>
                <div class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <div class="py-4 flex justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">₱{{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-900">
                            ₱{{ number_format($item->price * $item->quantity, 2) }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Total -->
            <div class="bg-gray-50 px-4 py-5 sm:px-6">
                <div class="flex justify-between">
                    <span class="text-base font-medium text-gray-900">Total</span>
                    <span class="text-base font-medium text-gray-900">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection