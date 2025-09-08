@extends('layouts.app')

@section('title', 'Pesanan Saya - Syneps Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Saya</h1>
        <p class="text-gray-600">Kelola dan lacak semua pesanan Anda</p>
    </div>

    @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="mt-2 md:mt-0">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex-shrink-0 w-16 h-16">
                                @if($order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                         alt="{{ $order->product->name }}" 
                                         class="w-full h-full object-cover rounded-md"
                                         onerror="this.src='https://via.placeholder.com/64x64?text=No+Image'">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">{{ $order->product->name }}</h4>
                                <p class="text-sm text-gray-600">Jumlah: {{ $order->quantity }} x {{ $order->product->formatted_price }}</p>
                                <p class="text-lg font-semibold text-blue-600">{{ $order->formatted_total_price }}</p>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('orders.show', $order) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail
                            </a>

                            @if($order->status === 'pending')
                                <button onclick="openUploadModal('{{ $order->id }}')"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload Bukti Bayar
                                </button>
                            @elseif($order->status === 'paid')
                                <div class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Menunggu Konfirmasi
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M8 11v6a2 2 0 002 2h4a2 2 0 002-2v-6M8 11h8"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada pesanan</h3>
            <p class="mt-2 text-gray-500">Mulai belanja untuk melihat pesanan Anda di sini.</p>
            <a href="{{ route('products.index') }}" 
               class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

<!-- Upload Proof Modal -->
<div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-md w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Upload Bukti Pembayaran</h3>
            <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="proof_file" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih file (JPG, PNG, PDF - Max 5MB)
                </label>
                <input type="file" 
                       id="proof_file" 
                       name="proof_file" 
                       accept="image/*,.pdf"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="closeUploadModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUploadModal(orderId) {
        document.getElementById('uploadForm').action = `/orders/${orderId}/upload-proof`;
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }
    
    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
        document.getElementById('proof_file').value = '';
    }
</script>
@endsection