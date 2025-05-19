@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Section --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Orders</h1>
            <p class="mt-2 text-sm text-gray-700">Manage and track all customer orders</p>
        </div>
        
        {{-- Filter Controls --}}
        <div class="mt-4 sm:mt-0 flex items-center gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center gap-4">
                <div class="relative">
                    <select name="status" id="status-filter" 
                            class="appearance-none rounded-md border border-gray-300 px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">All Status</option>
                        <option value="Order Placed" {{ request('status') == 'Order Placed' ? 'selected' : '' }}>Order Placed</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select name="payment_method" id="payment-method-filter" 
                            class="appearance-none rounded-md border border-gray-300 px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">All Payment Methods</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search orders..." 
                           class="pl-10 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Search
                </button>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $orders->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Add more stat cards here --}}
    </div>

    {{-- Orders Table --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Order #</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Payment Method</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Payment</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $order->order_number }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $order->user->name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                            {{ $order->status === 'Delivered' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'Order Placed' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-blue-100 text-blue-800') }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->payment_method === 'paypal' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                @if($order->payment_method === 'paypal')
                                    <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.067 8.478c.492.315.844.825.983 1.466a6.378 6.378 0 0 1-.545 3.692 5.48 5.48 0 0 1-1.716 2.313c-.603.57-1.333 1.017-2.132 1.316-.902.33-1.857.49-2.819.472H12.79l-.407 2.91a.5.5 0 0 1-.495.424h-2.09a.5.5 0 0 1-.494-.576l.208-1.485.478-3.4.456-3.249a.5.5 0 0 1 .495-.424h3.366c.662-.012 1.322.074 1.958.254.514.146.999.372 1.438.673z"/>
                                    </svg>
                                    PayPal
                                @else
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    COD
                                @endif
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 
                                'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Enhanced Pagination --}}
    <div class="mt-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing 
                <span class="font-medium">{{ $orders->firstItem() }}</span>
                to 
                <span class="font-medium">{{ $orders->lastItem() }}</span>
                of 
                <span class="font-medium">{{ $orders->total() }}</span>
                orders
            </div>
            <div>
                {{ $orders->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>

{{-- Add JavaScript for filtering --}}
<script>
    document.getElementById('status-filter').addEventListener('change', function(e) {
        this.closest('form').submit();
    });

    //  live search functionality
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.closest('form').submit();
        }, 500);
    });

    //  event listener for payment method filter
    document.getElementById('payment-method-filter').addEventListener('change', function(e) {
        this.closest('form').submit();
    });
</script>
@endsection