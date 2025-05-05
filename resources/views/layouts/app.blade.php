<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name', 'Griya Jahit'))</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 font-sans">
  {{-- Navbar --}}
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="flex items-center text-lg font-semibold text-gray-800">
            <x-application-logo class="h-8 w-8 mr-2" /> Griya Jahit
          </a>
        </div>
        <div class="flex items-center">
          @auth
            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:underline mr-4">
              {{ __('Dashboard') }}
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
              @csrf
              <button type="submit" class="text-red-600 hover:underline">
                {{ __('Log Out') }}
              </button>
            </form>
          @else
            <a href="{{ route('login') }}" class="text-gray-700 hover:underline mr-4">{{ __('Log in') }}</a>
            <a href="{{ route('register') }}" class="text-gray-700 hover:underline">{{ __('Register') }}</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    </div>
  @endif

  {{-- Page Content --}}
  <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    @yield('content')
  </main>

</body>
</html>
