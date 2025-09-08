@props(['product'])

<div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
    <!-- Product Image -->
    <div class="relative h-48 overflow-hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                 onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        <!-- Stock Badge -->
        @if($product->stock <= 5 && $product->stock > 0)
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                Stok: {{ $product->stock }}
            </div>
        @elseif($product->stock == 0)
            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                Habis
            </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
        
        <div class="flex items-center justify-between">
            <div class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</div>
            <div class="text-sm text-gray-500">Stok: {{ $product->stock }}</div>
        </div>
        
        <!-- Action Button -->
        <div class="mt-4">
            @if($product->stock > 0)
                <a href="{{ route('products.show', $product) }}" 
                   class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition-colors duration-200 text-center block">
                    Lihat Detail
                </a>
            @else
                <button disabled 
                        class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-md cursor-not-allowed text-center">
                    Stok Habis
                </button>
            @endif
        </div>
    </div>
</div>