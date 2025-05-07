<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en" class="min-h-screen flex flex-col">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tindahan ni Aling Nena</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Baloo 2', cursive;
    }
    .nav-item:hover {
      transform: scale(1.1);
      transition: transform 0.3s ease;
    }
    .navbar {
      background-image: linear-gradient(to right, #ffecd2, #fcb69f);
    }
  </style>
</head>
<body class="bg-yellow-50 flex flex-col flex-grow">

  <!-- Header -->
  <header class="bg-orange-400 text-white p-6 flex items-center justify-between shadow-md">
    <div class="text-2xl font-bold">Tindahan ni Aling Nena</div>

    <div class="flex items-center space-x-3">
      @auth
        <span class="text-lg text-white font-semibold">👋 Hi, {{ Auth::user()->name }}!</span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="bg-white text-orange-500 font-bold px-3 py-1 rounded hover:bg-orange-100">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="bg-white text-orange-500 font-bold px-3 py-1 rounded hover:bg-orange-100">Login</a>
        <a href="{{ route('register') }}" class="bg-white text-orange-500 font-bold px-3 py-1 rounded hover:bg-orange-100">Register</a>
      @endauth
    </div>
  </header>

  <!-- Navigation Bar -->
  <nav class="navbar sticky top-0 z-50 shadow-lg">
    <ul class="flex overflow-x-auto whitespace-nowrap p-4 space-x-6 justify-center text-sm md:text-base">
      <li class="nav-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="nav-item"><a href="{{ route('snacks') }}">Snacks</a></li>
      <li class="nav-item"><a href="{{ route('drinks') }}">Drinks</a></li>
      <li class="nav-item"><a href="{{ route('canned') }}">Canned Goods</a></li>
      <li class="nav-item"><a href="{{ route('noodles') }}">Instant Noodles</a></li>
      <li class="nav-item"><a href="{{ route('toiletries') }}">Toiletries</a></li>
      <li class="nav-item"><a href="{{ route('household') }}">Household</a></li>
      <li class="nav-item"><a href="{{ route('school') }}">School Supplies</a></li>
      <li class="nav-item"><a href="{{ route('pasabuy') }}">Pasabuy</a></li>
      <li class="nav-item"><a href="{{ route('about') }}">About Us</a></li>
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

</body>
</html>
