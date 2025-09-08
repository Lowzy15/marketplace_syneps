@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Pesanan</h1>
        <p class="text-gray-600">Kelola semua pesanan dari pelanggan</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan ID pesanan atau nama pelanggan..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
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

    @if(isset($orders) && $orders->count() > 0)
        <!-- Orders List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($order->product->image)
                                                <img class="h-10 w-10 rounded object-cover" 
                                                     src="{{ asset('storage/' . $order->product->image) }}" 
                                                     alt="{{ $order->product->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->product->name }}</div>
                                            <div class="text-sm text-gray-500">Qty: {{ $order->quantity }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->formatted_total_price }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="viewOrder({{ $order->id }})" 
                                                class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        @if($order->status !== 'cancelled' && $order->status !== 'completed')
                                            <button onclick="updateStatus({{ $order->id }}, '{{ $order->status }}')" 
                                                    class="text-green-600 hover:text-green-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pesanan</h3>
            <p class="mt-2 text-gray-500">
                @if(request()->filled('search') || request()->filled('status'))
                    Tidak ada pesanan yang sesuai dengan filter Anda.
                @else
                    Belum ada pesanan yang masuk.
                @endif
            </p>
            @if(request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.orders') }}" 
                   class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Lihat Semua Pesanan
                </a>
            @endif
        </div>
    @endif
</div>

<!-- View Order Modal -->
<div id="viewOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Detail Pesanan</h3>
            <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="orderDetails">
            <!-- Order details will be loaded here -->
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-md w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Update Status Pesanan</h3>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="statusForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                <select id="statusSelect" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending">Menunggu Pembayaran</option>
                    <option value="paid">Sudah Dibayar</option>
                    <option value="processing">Sedang Diproses</option>
                    <option value="shipped">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="closeStatusModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function viewOrder(orderId) {
        // In real implementation, you would fetch order details via AJAX
        document.getElementById('orderDetails').innerHTML = `
            <div class="space-y-4">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
                <p class="text-center text-gray-500">Memuat detail pesanan...</p>
            </div>
        `;
        document.getElementById('viewOrderModal').classList.remove('hidden');
        document.getElementById('viewOrderModal').classList.add('flex');
    }
    
    function closeViewModal() {
        document.getElementById('viewOrderModal').classList.add('hidden');
        document.getElementById('viewOrderModal').classList.remove('flex');
    }
    
    function updateStatus(orderId, currentStatus) {
        document.getElementById('statusForm').action = `/admin/orders/${orderId}/status`;
        document.getElementById('statusSelect').value = currentStatus;
        document.getElementById('updateStatusModal').classList.remove('hidden');
        document.getElementById('updateStatusModal').classList.add('flex');
    }
    
    function closeStatusModal() {
        document.getElementById('updateStatusModal').classList.add('hidden');
        document.getElementById('updateStatusModal').classList.remove('flex');
    }
</script>
@endsection