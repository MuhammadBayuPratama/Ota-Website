<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Hotel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex">

    <aside class="w-64 bg-white min-h-screen border-r flex flex-col fixed">
        <div class="p-4 border-b">
            <h1 class="text-xl font-bold">Dashboard</h1>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Dashboard
            </a>
            <a href="{{ route('admin.booking.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Booking
            </a>
            <a href="{{ route('admin.kamar.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Kamar
            </a>
            <a href="{{ route('admin.fasilitas.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Fasilitas
            </a>
            <a href="{{ route('admin.category.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Kategori
            </a>
            <a href="{{ route('admin.addons.index') }}" class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                Addon
            </a>
        </nav>

        <div class="p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8">
        @yield('content')
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>