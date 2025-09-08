@extends('layouts.app')

@section('title', 'Syneps Marketplace - Marketplace Digital Terpercaya')

@section('content')
    <!-- Hero Section with Background Image -->
    <section class="relative bg-gray-50 py-16 overflow-hidden">
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Marketplace Digital Terpercaya</h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">Platform jual beli online yang aman dan mudah digunakan</p>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Mulai Belanja</a>
                @guest
                    <a href="{{ route('register') }}" class="border border-blue-500 text-blue-500 px-6 py-3 rounded-md hover:bg-blue-500 hover:text-white transition">Daftar</a>
                @endguest
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
                        'icon' => 'quality'
                    ],
                    [
                        'title' => 'Proses Mudah', 
                        'desc' => 'Belanja dan berjualan dengan proses yang sederhana',
                        'icon' => 'easy'
                    ],
                    [
                        'title' => 'Layanan Terpercaya', 
                        'desc' => 'Dukungan pelanggan yang responsif dan profesional',
                        'icon' => 'trusted'
                    ]
                ];
                @endphp

                @foreach($features as $feature)
                    <div class="text-center p-6 bg-gray-50 rounded-md shadow-sm hover:shadow-md transition">
                        <!-- Feature Icon -->
                        <div class="mb-4">
                            <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
                                @if($feature['icon'] === 'quality')
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($feature['icon'] === 'easy')
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                @endif
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
            
            @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Lihat Semua</a>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v4.01"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Segera Hadir</h3>
                    <p class="mt-2 text-gray-500">Produk-produk menarik akan segera tersedia di platform kami.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                        Jelajahi Produk
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">1000+</div>
                    <div class="text-gray-600">Produk Tersedia</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-600 mb-2">500+</div>
                    <div class="text-gray-600">Pelanggan Puas</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">50+</div>
                    <div class="text-gray-600">Kategori Produk</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-orange-600 mb-2">24/7</div>
                    <div class="text-gray-600">Customer Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section with Background -->
    <section class="relative py-12 bg-blue-500 text-white overflow-hidden">
        <div class="relative container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-6">Mulai Berjualan atau Berbelanja Hari Ini</h2>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pengguna yang telah mempercayai platform kami untuk kebutuhan jual beli online mereka.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-blue-500 px-6 py-3 rounded-md hover:bg-gray-100 transition font-medium">Bergabung Sekarang</a>
                    <a href="{{ route('login') }}" class="border border-white text-white px-6 py-3 rounded-md hover:bg-white hover:text-blue-500 transition font-medium">Masuk</a>
                @else
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('products.index') }}" class="bg-white text-blue-500 px-6 py-3 rounded-md hover:bg-gray-100 transition font-medium">Mulai Belanja</a>
                        <a href="{{ route('orders.index') }}" class="border border-white text-white px-6 py-3 rounded-md hover:bg-white hover:text-blue-500 transition font-medium">Lihat Pesanan</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-500 px-6 py-3 rounded-md hover:bg-gray-100 transition font-medium">Dashboard Admin</a>
                    @endif
                @endguest
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-10">Apa Kata Pelanggan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                $testimonials = [
                    [
                        'name' => 'Sarah Johnson',
                        'role' => 'Pelanggan Setia',
                        'message' => 'Platform yang sangat mudah digunakan dengan produk berkualitas. Pelayanan customer service juga sangat responsif.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=3B82F6&color=fff'
                    ],
                    [
                        'name' => 'Ahmad Rahman',
                        'role' => 'Pengusaha Online',
                        'message' => 'Sebagai penjual, saya sangat terbantu dengan fitur-fitur yang ada. Proses upload produk sangat mudah dan cepat.',
                        'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Rahman&background=10B981&color=fff'
                    ],
                    [
                        'name' => 'Lisa Chen',
                        'role' => 'Ibu Rumah Tangga',
                        'message' => 'Berbelanja di sini sangat praktis. Pengiriman cepat dan produk sesuai dengan deskripsi. Highly recommended!',
                        'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Chen&background=8B5CF6&color=fff'
                    ]
                ];
                @endphp

                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $testimonial['name'] }}</div>
                                <div class="text-sm text-gray-600">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">"{{ $testimonial['message'] }}"</p>
                        <div class="flex mt-4 text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Dapatkan Penawaran Terbaru</h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                Berlangganan newsletter kami dan dapatkan informasi produk terbaru, promo menarik, dan tips berbelanja.
            </p>
            <div class="max-w-md mx-auto">
                <form class="flex">
                    <input type="email" 
                           placeholder="Masukkan email Anda"
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-3 rounded-r-md hover:bg-blue-600 transition-colors font-medium">
                        Berlangganan
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2">
                    Kami menghormati privasi Anda. Bisa berhenti berlangganan kapan saja.
                </p>
            </div>
        </div>
    </section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection