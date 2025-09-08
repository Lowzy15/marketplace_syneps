@extends('layouts.app')

@section('title', 'Daftar - Syneps Marketplace')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Atau 
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        masuk ke akun yang sudah ada
                    </a>
                </p>
            </div>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           value="{{ old('name') }}"
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan nama lengkap Anda">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email') }}"
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror" 
                           placeholder="Masukkan email Anda">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror" 
                           placeholder="Masukkan password (min. 8 karakter)">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Konfirmasi password Anda">
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-center">
                <input id="terms" 
                       name="terms" 
                       type="checkbox" 
                       required
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    Saya setuju dengan 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Syarat & Ketentuan</a> 
                    dan 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Kebijakan Privasi</a>
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                        </svg>
                    </span>
                    Daftar
                </button>
            </div>
        </form>
        
        <!-- Benefits -->
        <div class="mt-6 p-4 bg-green-50 rounded-md">
            <h3 class="text-sm font-medium text-green-800 mb-2">Keuntungan Bergabung:</h3>
            <ul class="text-xs text-green-600 space-y-1">
                <li>• Akses ke ribuan produk berkualitas</li>
                <li>• Proses checkout yang mudah dan aman</li>
                <li>• Tracking pesanan real-time</li>
                <li>• Customer support 24/7</li>
            </ul>
        </div>
    </div>
</div>
@endsection