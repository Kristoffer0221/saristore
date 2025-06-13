<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="min-h-screen flex flex-col">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tindahan ni Aling Nena</title>
  <script src="https://cdn.tailwindcss.com"></script>
      <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
  <style>
    body {
        font-family: 'Baloo 2', cursive;
    }
    .nav-item {
        position: relative;
        transition: all 0.3s ease;
    }
    .nav-item::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background-color: #f97316; /* orange-500 */
        transition: width 0.3s ease;
    }
    .nav-item:hover::after {
        width: 100%;
    }
    .nav-item.active::after {
        width: 100%;
    }
    .nav-item > a,
    .nav-item > button {
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .nav-item:hover > a,
    .nav-item:hover > button {
        color: #f97316; /* orange-500 */
        font-weight: 600;
        transform: translateY(-1px);
    }
    .navbar {
        background-image: linear-gradient(to right, #ffecd2, #fcb69f);
    }
    .dropdown-menu {
        transform-origin: top;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
  </style>
  @stack('styles')
</head>
<body class="bg-yellow-50 flex flex-col flex-grow">

  <!-- Header -->
  <header class="bg-orange-400 text-white p-6 flex items-center justify-between shadow-md">
    <div class="text-2xl font-bold">Tindahan ni Aling Nena</div>

    <!-- Search Bar -->
    <div class="relative flex w-full max-w-md md:w-96">
        <form action="{{ route('search') }}" method="GET" class="flex w-full items-center">
            <div class="relative flex-1">
                <!-- Search Icon (Left) -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <!-- Search Input -->
                <input
                    type="text"
                    name="query"
                    id="searchInput"
                    placeholder="Search for products..."
                    value="{{ request('query') }}"
                    class="w-full pl-10 pr-10 py-2.5 text-sm text-gray-700 bg-white/90 backdrop-blur-sm rounded-lg
                           border-2 border-white/50 
                           placeholder-gray-400
                           focus:outline-none focus:border-orange-300 focus:ring-2 focus:ring-orange-300
                           transition-all duration-300 ease-in-out
                           shadow-sm hover:shadow-md"
                    autocomplete="off"
                >

                <!-- Clear Button -->
                <button 
                    type="button"
                    id="clearSearch"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center opacity-0 transition-opacity duration-200"
                    onclick="clearSearchInput()"
                >
                    <svg class="w-5 h-5 text-gray-400 hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Button -->
            <button
                type="submit"
                class="ml-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg shadow-sm hover:bg-orange-600
                       flex items-center justify-center transition-all duration-300 ease-in-out
                       hover:shadow-md active:scale-95"
            >
                Search
            </button>
        </form>
    </div>

    <div class="flex items-center space-x-3">
      @auth
        <!-- Profile Dropdown -->
        <div class="relative group" style="z-index: 999;"> <!-- Increased z-index -->
            <button class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl hover:bg-white/20 transition-all duration-200">
                <div class="h-8 w-8 bg-orange-100 rounded-full flex items-center justify-center">
                    <span class="text-orange-600 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-white transform group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transform group-hover:translate-y-0 translate-y-2 transition-all duration-200"
                 style="z-index: 999;"> <!-- Increased z-index -->
                <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-orange-50">
                    <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>
                
                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-orange-50">
                    <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    My Orders
                </a>

                <hr class="my-2 border-gray-100">
                
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
      @else
        <a href="{{ route('login') }}" class="bg-white/10 backdrop-blur-sm text-white font-semibold px-4 py-2 rounded-xl hover:bg-white/20 transition-all duration-200">
            Login
        </a>
        <a href="{{ route('register') }}" class="bg-white text-orange-500 font-semibold px-4 py-2 rounded-xl hover:bg-orange-100 transition-all duration-200">
            Register
        </a>
      @endauth
    </div>
  </header>

  <!-- Navigation Bar -->
  <nav class="navbar sticky top-0 z-50 shadow-lg">
    <ul class="flex overflow-visible relative z-40 whitespace-nowrap p-4 space-x-6 justify-center text-sm md:text-base">
        @auth
            @if(Auth::user()->is_admin)
                {{-- ADMIN DROPDOWN --}}
                <li class="nav-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-2">
                        <span>📦</span>
                        <span>All Products</span>
                    </a>
                </li>
                <li class="nav-item relative group">
                    <button class="flex items-center space-x-2 font-semibold focus:outline-none">
                        <span>🔧</span>
                        <span>Admin Menu</span>
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul class="absolute hidden group-hover:block bg-white shadow-lg text-orange-600 rounded-lg py-2 w-48 z-50 dropdown-menu">
                        <li><a href="{{ route('snacks') }}" class="block px-4 py-2 hover:bg-orange-100">🍫 Snacks</a></li>
                        <li><a href="{{ route('drinks') }}" class="block px-4 py-2 hover:bg-orange-100">🥤 Drinks</a></li>
                        <li><a href="{{ route('canned') }}" class="block px-4 py-2 hover:bg-orange-100">🥫 Canned Goods</a></li>
                        <li><a href="{{ route('noodles') }}" class="block px-4 py-2 hover:bg-orange-100">🍜 Instant Noodles</a></li>
                        <li><a href="{{ route('toiletries') }}" class="block px-4 py-2 hover:bg-orange-100">🧼 Toiletries</a></li>
                        <li><a href="{{ route('household') }}" class="block px-4 py-2 hover:bg-orange-100">🧹 Household</a></li>
                        <li><a href="{{ route('school') }}" class="block px-4 py-2 hover:bg-orange-100">✏️ School Supplies</a></li>
                        <li><a href="{{ route('pasabuy') }}" class="block px-4 py-2 hover:bg-orange-100">🛍️ Pasabuy</a></li>
                        <li><a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-orange-100">ℹ️ About Us</a></li>
                        <li><a href="{{ route('cart.index') }}" class="block px-4 py-2 hover:bg-orange-100">🛒 Cart</a></li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->routeIs('products.create') ? 'active' : '' }}">
                    <a href="{{ route('products.create') }}" class="flex items-center space-x-2">
                        <span>➕</span>
                        <span>Add Product</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.products.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.users') }}" class="flex items-center space-x-2">
                        <span>👤</span>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-2">
                        <span>📦</span>
                        <span>Orders</span>
                    </a>
                </li>
            @else
                {{-- REGULAR USER NAV --}}
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item {{ request()->routeIs('snacks') ? 'active' : '' }}">
                    <a href="{{ route('snacks') }}">Snacks</a>
                </li>
                <li class="nav-item {{ request()->routeIs('drinks') ? 'active' : '' }}">
                    <a href="{{ route('drinks') }}">Drinks</a>
                </li>
                <li class="nav-item {{ request()->routeIs('canned') ? 'active' : '' }}">
                    <a href="{{ route('canned') }}">Canned Goods</a>
                </li>
                <li class="nav-item {{ request()->routeIs('noodles') ? 'active' : '' }}">
                    <a href="{{ route('noodles') }}">Instant Noodles</a>
                </li>
                <li class="nav-item {{ request()->routeIs('toiletries') ? 'active' : '' }}">
                    <a href="{{ route('toiletries') }}">Toiletries</a>
                </li>
                <li class="nav-item {{ request()->routeIs('household') ? 'active' : '' }}">
                    <a href="{{ route('household') }}">Household</a>
                </li>
                <li class="nav-item {{ request()->routeIs('school') ? 'active' : '' }}">
                    <a href="{{ route('school') }}">School Supplies</a>
                </li>
                <li class="nav-item {{ request()->routeIs('pasabuy') ? 'active' : '' }}">
                    <a href="{{ route('pasabuy') }}">Pasabuy</a>
                </li>
                <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item relative">
                    <a href="{{ route('cart.index') }}" class="hover:text-orange-600 relative">
                      🛒 Cart
                      @php
                        $cart = session('cart', []);
                        $cartCount = collect($cart)->sum('quantity');
                      @endphp
                      @if($cartCount > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                          {{ $cartCount }}
                        </span>
                      @endif
                    </a>
                  </li>
            @endif
        @else
            {{-- GUEST USER NAV --}}
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ request()->routeIs('snacks') ? 'active' : '' }}">
                <a href="{{ route('snacks') }}">Snacks</a>
            </li>
            <li class="nav-item {{ request()->routeIs('drinks') ? 'active' : '' }}">
                <a href="{{ route('drinks') }}">Drinks</a>
            </li>
            <li class="nav-item {{ request()->routeIs('canned') ? 'active' : '' }}">
                <a href="{{ route('canned') }}">Canned Goods</a>
            </li>
            <li class="nav-item {{ request()->routeIs('noodles') ? 'active' : '' }}">
                <a href="{{ route('noodles') }}">Instant Noodles</a>
            </li>
            <li class="nav-item {{ request()->routeIs('toiletries') ? 'active' : '' }}">
                <a href="{{ route('toiletries') }}">Toiletries</a>
            </li>
            <li class="nav-item {{ request()->routeIs('household') ? 'active' : '' }}">
                <a href="{{ route('household') }}">Household</a>
            </li>
            <li class="nav-item {{ request()->routeIs('school') ? 'active' : '' }}">
                <a href="{{ route('school') }}">School Supplies</a>
            </li>
            <li class="nav-item {{ request()->routeIs('pasabuy') ? 'active' : '' }}">
                <a href="{{ route('pasabuy') }}">Pasabuy</a>
            </li>
            <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item relative">
                <a href="{{ route('cart.index') }}" class="hover:text-orange-600 relative">
                  🛒 Cart
                  @php
                    $cart = session('cart', []);
                    $cartCount = collect($cart)->sum('quantity');
                  @endphp
                  @if($cartCount > 0)
                    <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                      {{ $cartCount }}
                    </span>
                  @endif
                </a>
              </li>
        @endauth
    </ul>


  </nav>

  

  <!-- Main Content -->
  <main class="flex-grow">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-orange-300 text-center text-white py-4">
    &copy; 2025 Tindahan ni Aling Nena. All rights reserved.
  </footer>

  <!-- Add this script section at the bottom of your body tag -->
  <script>
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearSearch');

    // Show/hide clear button based on input
    searchInput.addEventListener('input', function() {
        clearButton.style.opacity = this.value ? '1' : '0';
    });

    // Initialize clear button visibility
    window.addEventListener('load', function() {
        clearButton.style.opacity = searchInput.value ? '1' : '0';
    });

    // Clear search input
    function clearSearchInput() {
        searchInput.value = '';
        clearButton.style.opacity = '0';
        searchInput.focus();
    }

    // Add keyboard shortcut (Esc) to clear search
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Escape') {
            clearSearchInput();
        }
    });

    // Add focus animation
    searchInput.addEventListener('focus', function() {
        this.parentElement.classList.add('scale-105');
    });

    searchInput.addEventListener('blur', function() {
        this.parentElement.classList.remove('scale-105');
    });
</script>
@stack('scripts')
</body>
</html>
