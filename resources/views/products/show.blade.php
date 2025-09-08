@extends('layouts.app')

@section('title', $product->name . ' - Syneps Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-blue-600">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">Produk</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500 truncate">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="space-y-4">
            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://via.placeholder.com/500x500?text=No+Image'">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-blue-600">{{ $product->formatted_price }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-700">Stok:</span>
                    <span class="text-sm font-bold {{ $product->stock > 5 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $product->stock }} unit
                    </span>
                </div>
                
                @if($product->stock <= 5 && $product->stock > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Stok Terbatas
                    </span>
                @elseif($product->stock == 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Habis
                    </span>
                @endif
            </div>

            <!-- Order Form -->
            @auth
                @if(auth()->user()->role === 'user' && $product->stock > 0)
                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <div class="flex items-center space-x-3">
                                <button type="button" 
                                        onclick="decreaseQuantity()" 
                                        class="w-10 h-10 rounded-md border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}"
                                       class="w-20 text-center px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" 
                                        onclick="increaseQuantity()" 
                                        class="w-10 h-10 rounded-md border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-md">
                            <span class="text-lg font-medium text-gray-900">Total:</span>
                            <span id="totalPrice" class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</span>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition-colors duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.35 4.5M7 13l-1.35 4.5M17 21a2 2 0 11-4 0 2 2 0 014 0zM9 21a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Pesan Sekarang</span>
                        </button>
                    </form>
                @elseif(auth()->user()->role === 'admin')
                    <div class="p-4 bg-blue-50 rounded-md">
                        <p class="text-blue-800">Anda login sebagai admin. Gunakan dashboard untuk mengelola produk ini.</p>
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Edit Produk
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-gray-100 rounded-md">
                        <p class="text-gray-600 text-center">Produk ini sedang tidak tersedia</p>
                    </div>
                @endif
            @else
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                    <p class="text-yellow-800 text-center">
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Masuk</a> 
                        untuk dapat memesan produk ini
                    </p>
                </div>
            @endauth

            <!-- Additional Info -->
            <div class="space-y-4 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-gray-700">Produk Original & Bergaransi</span>
                </div>
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-gray-700">Pengiriman ke Seluruh Indonesia</span>
                </div>
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-gray-700">Pembayaran Aman & Mudah</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const pricePerUnit = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    
    function updateTotal() {
        const quantity = document.getElementById('quantity').value;
        const total = pricePerUnit * quantity;
        document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < maxStock) {
            quantityInput.value = currentValue + 1;
            updateTotal();
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    }
    
    // Update total when quantity changes
    document.getElementById('quantity').addEventListener('input', updateTotal);
</script>
@endsection