@extends('layouts.app')

@section('title', 'Tambah Produk - Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500">Tambah Produk</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Produk Baru</h1>
        <p class="text-gray-600">Isi form di bawah untuk menambahkan produk baru ke marketplace</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Product Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama produk">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price and Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}"
                               min="0"
                               step="1000"
                               required
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror"
                               placeholder="0">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock') }}"
                           min="0"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock') border-red-500 @enderror"
                           placeholder="Jumlah stok">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Produk
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-md p-6 hover:border-blue-400 transition-colors">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-4">
                            <label for="image" class="cursor-pointer">
                                <span class="mt-2 block text-sm font-medium text-gray-900">
                                    Klik untuk upload atau drag & drop
                                </span>
                                <span class="mt-2 block text-sm text-gray-500">
                                    PNG, JPG, JPEG up to 2MB
                                </span>
                            </label>
                            <input id="image" 
                                   name="image" 
                                   type="file" 
                                   accept="image/*"
                                   class="sr-only"
                                   onchange="previewImage(this)">
                        </div>
                    </div>
                </div>
                
                <!-- Image Preview -->
                <div id="imagePreview" class="hidden mt-4">
                    <div class="relative inline-block">
                        <img id="preview" src="" alt="Preview" class="h-32 w-32 object-cover rounded-md border">
                        <button type="button" 
                                onclick="removeImage()"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Status -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Produk
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_active" 
                               value="0" 
                               {{ old('is_active') == '0' ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
    
    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').classList.add('hidden');
        document.getElementById('preview').src = '';
    }
    
    // Format price input
    document.getElementById('price').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        e.target.value = value;
    });
</script>
@endsection