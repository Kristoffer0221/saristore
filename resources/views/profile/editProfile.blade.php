@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-yellow-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <!-- Page Header with Back Button -->
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-yellow-600">
                        Edit Profile
                    </span>
                </h1>
                <p class="mt-3 text-lg text-gray-600">Customize your account settings and preferences</p>
            </div>
            
            <a href="{{ route('profile.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Profile
            </a>
        </div>

        

            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Profile Information Section -->
                <div id="profile" class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Profile Information</h2>
                            <span class="px-4 py-1.5 bg-orange-100 text-orange-600 rounded-full text-sm font-medium">
                                Personal Details
                            </span>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security Section -->
                <div id="security" class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Security Settings</h2>
                            <span class="px-4 py-1.5 bg-blue-100 text-blue-600 rounded-full text-sm font-medium">
                                Password & Security
                            </span>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div id="danger" class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-red-600">Danger Zone</h2>
                            <span class="px-4 py-1.5 bg-red-100 text-red-600 rounded-full text-sm font-medium">
                                Account Deletion
                            </span>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>

<!-- Notification -->
@if (session('status'))
    <div id="notification" 
         class="fixed bottom-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl shadow-lg transform transition-all duration-500 ease-in-out"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('status') }}
        </div>
    </div>
@endif
@endsection
