@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - Syneps Marketplace')

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
                    <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-blue-600">Pesanan Saya</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500">Order #{{ $order->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                        <p class="text-gray-600">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Order Progress -->
                <div class="mt-6">
                    <div class="flex items-center">
                        @php
                            $steps = ['pending', 'paid', 'processing', 'shipped', 'completed'];
                            $currentStepIndex = array_search($order->status, $steps);
                            if ($currentStepIndex === false) $currentStepIndex = 0;
                        @endphp
                        
                        @foreach($steps as $index => $step)
                            <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $index <= $currentStepIndex ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="mt-2 text-xs text-gray-600 text-center">
                                        @switch($step)
                                            @case('pending') Menunggu @break
                                            @case('paid') Dibayar @break
                                            @case('processing') Diproses @break
                                            @case('shipped') Dikirim @break
                                            @case('completed') Selesai @break
                                        @endswitch
                                    </span>
                                </div>
                                @if($index < count($steps) - 1)
                                    <div class="flex-1 h-0.5 mx-2 {{ $index < $currentStepIndex ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Produk</h2>
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 w-20 h-20">
                        @if($order->product->image)
                            <img src="{{ asset('storage/' . $order->product->image) }}" 
                                 alt="{{ $order->product->name }}" 
                                 class="w-full h-full object-cover rounded-md"
                                 onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                        @else
                            <div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">{{ $order->product->name }}</h3>
                        <p class="text-gray-600 mt-1">{{ Str::limit($order->product->description, 100) }}</p>
                        <div class="mt-2 flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Jumlah: {{ $order->quantity }}</span>
                            <span class="text-sm text-gray-600">Harga: {{ $order->product->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            @if($order->proof_file)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Bukti Pembayaran</h2>
                    <div class="border border-gray-200 rounded-lg p-4">
                        @if(Str::endsWith($order->proof_file, ['.pdf']))
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">Dokumen PDF</p>
                                    <a href="{{ asset('storage/' . $order->proof_file) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $order->proof_file) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="max-w-full h-auto rounded-md cursor-pointer"
                                 onclick="openImageModal('{{ asset('storage/' . $order->proof_file) }}')">
                        @endif
                        <p class="text-xs text-gray-500 mt-2">
                            Diupload pada {{ \Carbon\Carbon::parse($order->updated_at)->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal ({{ $order->quantity }} item)</span>
                        <span class="text-gray-900">{{ $order->formatted_total_price }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="text-gray-900">Gratis</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="text-gray-900">Gratis</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-semibold text-lg">
                        <span class="text-gray-900">Total</span>
                        <span class="text-blue-600">{{ $order->formatted_total_price }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h2>
                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <button onclick="openUploadModal()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span>Upload Bukti Bayar</span>
                        </button>
                    @endif
                    
                    <a href="{{ route('products.show', $order->product) }}" 
                       class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors text-center block">
                        Lihat Produk Lagi
                    </a>
                    
                    <a href="{{ route('orders.index') }}" 
                       class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors text-center block">
                        Kembali ke Pesanan
                    </a>
                </div>
            </div>

            <!-- Customer Service -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Butuh Bantuan?</h3>
                <p class="text-blue-700 text-sm mb-3">Tim customer service kami siap membantu Anda 24/7</p>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 text-sm text-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>support@syneps.com</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+62 812-3456-7890</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        
        <form action="{{ route('orders.upload-proof', $order) }}" method="POST" enctype="multipart/form-data">
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
                <p class="text-xs text-gray-500 mt-1">
                    Upload bukti transfer/pembayaran Anda di sini
                </p>
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

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="relative max-w-4xl max-h-full p-4">
        <button onclick="closeImageModal()" 
                class="absolute top-2 right-2 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

<script>
    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }
    
    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
        document.getElementById('proof_file').value = '';
    }
    
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    }
    
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
    }
</script>
@endsection