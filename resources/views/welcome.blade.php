<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syneps Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-white">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo dengan dukungan gambar -->
            <div class="flex items-center">
                <!-- Uncomment baris di bawah jika sudah ada logo -->
                {{-- <img src="{{ asset('images/logo.png') }}" alt="Syneps Logo" class="h-8 w-auto mr-2"> --}}
                <div class="text-2xl font-bold text-blue-500">SYNEPS MARKET</div>
            </div>
            
            <div class="hidden md:flex space-x-6 items-center">
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">Beranda</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">Produk</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">Tentang</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 transition">Masuk</a>
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Daftar</a>
            </div>
            <button class="md:hidden focus:outline-none" onclick="toggleMenu()">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </nav>
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-blue-500">Beranda</a>
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-blue-500">Produk</a>
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-blue-500">Tentang</a>
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-blue-50 hover:text-blue-500">Masuk</a>
            <a href="#" class="block px-4 py-2 bg-blue-500 text-white text-center hover:bg-blue-600">Daftar</a>
        </div>
    </header>

    <!-- Hero Section with Background Image -->
    <section class="relative bg-gray-50 py-16 overflow-hidden">
        <!-- Background Image (optional) -->
        {{-- <div class="absolute inset-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Hero Background" class="w-full h-full object-cover opacity-10">
        </div> --}}
        
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Marketplace Digital Terpercaya</h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">Platform jual beli online yang aman dan mudah digunakan</p>
            
            <!-- Hero Image -->
            <div class="mb-8">
                {{-- <img src="{{ asset('images/hero-illustration.png') }}" alt="Hero Illustration" class="mx-auto max-w-md w-full h-auto"> --}}
            </div>
            
            <div class="flex justify-center space-x-4">
                <a href="#" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Mulai Belanja</a>
                <a href="#" class="border border-blue-500 text-blue-500 px-6 py-3 rounded-md hover:bg-blue-500 hover:text-white transition">Daftar</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-10">Keunggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                $features = [
                    [
                        'title' => 'Kualitas Terjamin', 
                        'desc' => 'Produk dijamin asli dan berkualitas tinggi',
                        'icon' => 'quality-icon.png' // nama file icon di public/images
                    ],
                    [
                        'title' => 'Proses Mudah', 
                        'desc' => 'Belanja dan berjualan dengan proses yang sederhana',
                        'icon' => 'easy-process-icon.png'
                    ],
                    [
                        'title' => 'Layanan Terpercaya', 
                        'desc' => 'Dukungan pelanggan yang responsif dan profesional',
                        'icon' => 'trusted-service-icon.png'
                    ]
                ];
                @endphp

                @foreach($features as $feature)
                    <div class="text-center p-6 bg-gray-50 rounded-md shadow-sm hover:shadow-md transition">
                        <!-- Feature Icon -->
                        <div class="mb-4">
                            {{-- <img src="{{ asset('images/' . $feature['icon']) }}" alt="{{ $feature['title'] }}" class="w-12 h-12 mx-auto"> --}}
                            <!-- Placeholder untuk icon sementara menggunakan div -->
                            <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
                                <div class="w-6 h-6 bg-blue-500 rounded-full"></div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Product Preview Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-10">Produk Unggulan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @php
                $products = [
                    [
                        'name' => 'Produk A', 
                        'price' => 'Rp 200.000', 
                        'image' => 'product-1.jpg', // nama file di public/images
                        'placeholder' => 'https://via.placeholder.com/300x200'
                    ],
                    [
                        'name' => 'Produk B', 
                        'price' => 'Rp 350.000', 
                        'image' => 'product-2.jpg',
                        'placeholder' => 'https://via.placeholder.com/300x200'
                    ],
                    [
                        'name' => 'Produk C', 
                        'price' => 'Rp 150.000', 
                        'image' => 'product-3.jpg',
                        'placeholder' => 'https://via.placeholder.com/300x200'
                    ],
                    [
                        'name' => 'Produk D', 
                        'price' => 'Rp 500.000', 
                        'image' => 'product-4.jpg',
                        'placeholder' => 'https://via.placeholder.com/300x200'
                    ]
                ];
                @endphp

                @foreach($products as $product)
                    <div class="bg-white rounded-md shadow-sm hover:shadow-md transition">
                        <!-- Product Image dengan fallback -->
                        <div class="relative h-40 overflow-hidden rounded-t-md">
                            <img src="{{ file_exists(public_path('images/' . $product['image'])) ? asset('images/' . $product['image']) : $product['placeholder'] }}" 
                                 alt="{{ $product['name'] }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='{{ $product['placeholder'] }}'">
                        </div>
                        <div class="p-4">
                            <h3 class="text-md font-semibold text-gray-800">{{ $product['name'] }}</h3>
                            <p class="text-blue-500 font-medium">{{ $product['price'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="#" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Lihat Semua</a>
            </div>
        </div>
    </section>

    <!-- CTA Section with Background -->
    <section class="relative py-12 bg-blue-500 text-white overflow-hidden">
        <!-- Background Pattern/Image -->
        {{-- <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('images/cta-bg.png') }}" alt="CTA Background" class="w-full h-full object-cover">
        </div> --}}
        
        <div class="relative container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-6">Mulai Berjualan atau Berbelanja Hari Ini</h2>
            <a href="#" class="bg-white text-blue-500 px-6 py-3 rounded-md hover:bg-gray-100 transition">Bergabung Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 flex items-center">
                    <!-- Footer Logo -->
                    {{-- <img src="{{ asset('images/logo-white.png') }}" alt="Syneps Logo" class="h-6 w-auto mr-2"> --}}
                    <p>&copy; 2025 Syneps Marketplace. Hak cipta dilindungi.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-blue-500 transition">Tentang</a>
                    <a href="#" class="hover:text-blue-500 transition">Kontak</a>
                    <a href="#" class="hover:text-blue-500 transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-blue-500 transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Image loading optimization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded successfully!');
        });
    </script>
</body>
</html>