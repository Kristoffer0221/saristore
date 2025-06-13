<x-guest-layout>
    
            <!-- Header Section -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-orange-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Create Account</h2>
                <p class="mt-2 text-sm text-gray-600">Join our community today</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Name -->
                <div class="space-y-2">
                    <x-input-label for="name" :value="__('Full Name')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <x-text-input id="name" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            placeholder="John Doe"
                            required 
                            autofocus 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm" />
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <x-input-label for="email" :value="__('Email Address')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <x-text-input id="email" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            placeholder="john@example.com"
                            required 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
                </div>

                <!-- Phone Number -->
                <div class="space-y-2">
                    <x-input-label for="phone" :value="__('Phone Number')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <x-text-input id="phone" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="tel" 
                            name="phone" 
                            :value="old('phone')" 
                            placeholder="+1 (555) 000-0000"
                            required 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1 text-sm" />
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <x-input-label for="address" :value="__('Address')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <x-text-input id="address" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="text" 
                            name="address" 
                            :value="old('address')" 
                            placeholder="123 Main St, City, Country"
                            required 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('address')" class="mt-1 text-sm" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="password" 
                            name="password" 
                            placeholder="••••••••"
                            required 
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password_confirmation" 
                            class="pl-10 w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            type="password" 
                            name="password_confirmation" 
                            placeholder="••••••••"
                            required 
                        />
                    </div>
                </div>

                <!-- Terms & Register Button -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <label for="terms" class="ml-2 block text-sm text-gray-600">
                            I agree to the <a href="#" class="text-orange-600 hover:text-orange-500">Terms of Service</a> and <a href="#" class="text-orange-600 hover:text-orange-500">Privacy Policy</a>
                        </label>
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3 bg-orange-600 hover:bg-orange-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-orange-600 hover:text-orange-500 transition-colors duration-200">
                            Sign in instead
                        </a>
                    </p>
                </div>
            </form>
        
</x-guest-layout>
