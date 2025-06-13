@extends('layouts.app')

@section('content')
<div class="py-8 bg-yellow-50">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center space-x-6">
                <!-- Profile Avatar -->
                <div class="h-24 w-24 bg-orange-100 rounded-full flex items-center justify-center">
                    <span class="text-4xl font-bold text-orange-600">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                
                <!-- Basic Info -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">Member since {{ $user->created_at->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact Information</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium">{{ $user->phone ?? 'Not Set' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-orange-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">{{ $user->address ?? 'Not Set' }}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.editProfile') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Profile
                </a>
            </div>

            <!-- Order Statistics -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Statistics</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="text-sm text-orange-600 mb-1">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $user->orders()->count() }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="text-sm text-orange-600 mb-1">Total Spent</p>
                        <p class="text-2xl font-bold text-gray-800">₱{{ number_format($user->orders()->sum('total_amount'), 2) }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-medium text-gray-700 mb-3">Recent Orders</h3>
                    @forelse($user->orders()->latest()->take(3)->get() as $order)
                        <div class="flex items-center justify-between py-3 border-b last:border-0">
                            <div>
                                <p class="font-medium">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="font-medium text-orange-600">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No orders yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection