<x-guest-layout>
    
        <h2 class="text-3xl font-bold text-center text-orange-600 mb-6">Welcome Back!</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded border-gray-300 focus:ring-orange-500 focus:border-orange-500"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full rounded border-gray-300 focus:ring-orange-500 focus:border-orange-500"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-4">
                <label for="remember_me" class="flex items-center text-sm">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500"
                        name="remember">
                    <span class="ml-2 text-gray-700">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-orange-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600">
                {{ __('Log in') }}
            </x-primary-button>
        </form>
        <div class="mt-4 text-center">
            <span class="text-gray-600">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-orange-600 hover:underline">Register</a>
        </div>
</x-guest-layout>
