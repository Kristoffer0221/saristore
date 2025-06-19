@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-sm p-8">
        <!-- Modern About Us Section -->
        <div class="flex flex-col md:flex-row items-center gap-10 mb-16">
            <!-- Image Left -->
            <div class="md:w-1/2 w-full flex justify-center">
                <img src="{{ asset('images/sariLogowBG.jpg') }}" alt="About Us" class="rounded-xl shadow-md w-full max-w-md object-cover">
            </div>
            <!-- Text Right -->
            <div class="md:w-1/2 w-full">
                <h1 class="text-4xl font-bold text-orange-600 mb-4">About Tindahan ni Aling Nena</h1>
                <p class="text-gray-700 text-lg mb-6">
                    Welcome to your neighborhood store, now online! We bring you the warmth and convenience of your favorite sari-sari store, offering a wide range of everyday essentials delivered right to your doorstep.
                </p>
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-lg shadow-sm mb-6">
                    <h2 class="text-2xl font-semibold text-orange-700 mb-2">Our Mission</h2>
                    <p class="text-gray-700">
                        To make daily shopping easy, affordable, and accessible for every Filipino family by combining trusted local service with modern technology.
                    </p>
                </div>
                <!-- Additional Content: Shop Info & Values -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 bg-orange-100 rounded-lg p-4 flex items-center gap-3 shadow-sm">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4m-5 4h18"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-orange-700">Open Everyday</h3>
                            <p class="text-sm text-gray-600">7:00 AM - 9:00 PM</p>
                        </div>
                    </div>
                    <div class="flex-1 bg-orange-100 rounded-lg p-4 flex items-center gap-3 shadow-sm">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 0V4m0 7v7"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-orange-700">Affordable Prices</h3>
                            <p class="text-sm text-gray-600">Everyday essentials for every budget</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Why Choose Us</h1>
        <p class="text-center text-gray-600 mb-12">Experience the best shopping with Tindahan ni Aling Nena</p>
        <div class="grid md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col items-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4m-5 4h18"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-center mb-2">Convenient Location</h3>
                <p class="text-gray-600 text-center">Located in your neighborhood for fast and easy access.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col items-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 0V4m0 7v7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-center mb-2">Affordable Prices</h3>
                <p class="text-gray-600 text-center">Everyday essentials at prices you'll love.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col items-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 018 0v2M5 21h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-center mb-2">Friendly Service</h3>
                <p class="text-gray-600 text-center">Our staff is always ready to help you with a smile.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col items-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M9 3v18m6-18v18"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-center mb-2">Wide Selection</h3>
                <p class="text-gray-600 text-center">From snacks to household needs, we have it all.</p>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="flex flex-col md:flex-row items-center justify-between bg-orange-50 rounded-lg p-8 mt-8 gap-6">
            <div>
                <h2 class="text-2xl font-bold text-orange-700 mb-2">Visit Us or Shop Online!</h2>
                <p class="text-gray-700 mb-2">Experience the convenience of shopping at Tindahan ni Aling Nena—whether you drop by our store or order from the comfort of your home.</p>
                <p class="text-gray-600">📍 123 Barangay St., Your City, Philippines</p>
                <p class="text-gray-600">☎️ 0912-345-6789</p>
            </div>
            <a href="{{ route('home') }}" class="mt-4 md:mt-0 inline-block bg-orange-600 text-white px-6 py-3 rounded-md font-semibold shadow hover:bg-orange-700 transition-colors duration-300">
                Shop Now
            </a>
        </div>
    </div>
</div>
@endsection