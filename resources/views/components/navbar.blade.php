<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold text-blue-500">
                SYNEPS MARKET
            </a>
        </div>
        
        <!-- Desktop Navigation -->
        <div class="hidden md:flex space-x-6 items-center">
            <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-blue-500 transition">Beranda</a>
            
            @auth
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-500 transition">Produk</a>
                
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-blue-500 transition">Pesanan Saya</a>
                @endif
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-500 transition">Dashboard</a>
                @endif
                
                <!-- User Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 transition">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="py-1">
                            <div class="px-4 py-2 text-sm text-gray-500 border-b">
                                {{ auth()->user()->email }}
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-500 transition">Produk</a>
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-500 transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Daftar</a>
            @endauth
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="md:hidden focus:outline-none" onclick="toggleMobileMenu()">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </nav>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
        <div class="px-4 py-2 space-y-2">
            <a href="{{ route('welcome') }}" class="block py-2 text-gray-600 hover:text-blue-500">Beranda</a>
            
            @auth
                <a href="{{ route('products.index') }}" class="block py-2 text-gray-600 hover:text-blue-500">Produk</a>
                
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('orders.index') }}" class="block py-2 text-gray-600 hover:text-blue-500">Pesanan Saya</a>
                @endif
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-600 hover:text-blue-500">Dashboard</a>
                @endif
                
                <div class="border-t pt-2 mt-2">
                    <div class="text-sm text-gray-500 py-1">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-400 py-1">{{ auth()->user()->email }}</div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-red-600 hover:text-red-700">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('products.index') }}" class="block py-2 text-gray-600 hover:text-blue-500">Produk</a>
                <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-blue-500">Masuk</a>
                <a href="{{ route('register') }}" class="block py-2 bg-blue-500 text-white text-center rounded hover:bg-blue-600">Daftar</a>
            @endauth
        </div>
    </div>
</header>