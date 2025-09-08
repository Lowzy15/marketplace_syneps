@extends('layouts.app')

@section('title', 'Admin Dashboard - Syneps Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">Kelola produk dan pesanan marketplace Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Produk</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalProducts ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pesanan</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Perlu Konfirmasi</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pendapatan</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $revenue ?? 'Rp 0' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Product Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Produk</h2>
                <a href="{{ route('admin.products.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors text-sm">
                    + Tambah Produk
                </a>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" 
                   class="flex items-center p-3 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-gray-700">Tambah Produk Baru</span>
                </a>
                
                <a href="{{ route('products.index') }}" 
                   class="flex items-center p-3 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="text-gray-700">Lihat Semua Produk</span>
                </a>
            </div>
        </div>

        <!-- Order Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Pesanan</h2>
                <a href="{{ route('admin.orders') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors text-sm">
                    Lihat Semua
                </a>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('admin.orders') }}?status=paid" 
                   class="flex items-center justify-between p-3 bg-yellow-50 border border-yellow-200 rounded-md hover:bg-yellow-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Perlu Konfirmasi</span>
                    </div>
                    <span class="bg-yellow-600 text-white px-2 py-1 rounded-full text-xs">{{ $pendingOrders ?? 0 }}</span>
                </a>
                
                <a href="{{ route('admin.orders') }}" 
                   class="flex items-center p-3 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-gray-700">Kelola Semua Pesanan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Products & Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Produk Terbaru</h2>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($recentProducts) && $recentProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentProducts as $product)
                            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-md">
                                <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover rounded-md">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $product->formatted_price }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.products.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Produk
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($recentOrders) && $recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div>
                                    <h3 class="font-medium text-gray-900">Order #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-blue-100 text-blue-800',
                                            'processing' => 'bg-purple-100 text-purple-800',
                                            'shipped' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $order->status_label }}
                                    </span>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $order->formatted_total_price }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Pesanan akan muncul di sini setelah ada yang memesan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection