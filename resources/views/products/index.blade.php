@extends('layouts.app')

@section('title', 'Semua Produk - Syneps Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Semua Produk</h1>
        <p class="text-gray-600">Temukan produk terbaik untuk kebutuhan Anda</p>
    </div>
    
    <!-- Filters & Search -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari produk..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="sort" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Urutkan</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                </select>
            </div>
            <div>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>
    
    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v4.01"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada produk ditemukan</h3>
            <p class="mt-2 text-gray-500">
                @if(request()->filled('search'))
                    Coba kata kunci lain untuk pencarian Anda.
                @else
                    Belum ada produk yang tersedia saat ini.
                @endif
            </p>
            @if(request()->filled('search') || request()->filled('sort'))
                <a href="{{ route('products.index') }}" 
                   class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Lihat Semua Produk
                </a>
            @endif
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection