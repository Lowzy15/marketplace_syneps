<?php

use Illuminate\Support\Facades\Route;

// Public routes untuk login dan register
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Halaman utama (welcome)
Route::get('/', function () {
    // Data dummy sebagai koleksi
    $products = collect([
        (object) ['id' => 1, 'name' => 'Produk 1', 'description' => 'Deskripsi produk 1', 'price' => 100000, 'image' => 'https://via.placeholder.com/150', 'stock' => 10],
        (object) ['id' => 2, 'name' => 'Produk 2', 'description' => 'Deskripsi produk 2', 'price' => 200000, 'image' => 'https://via.placeholder.com/150', 'stock' => 5],
        (object) ['id' => 3, 'name' => 'Produk 3', 'description' => 'Deskripsi produk 3', 'price' => 150000, 'image' => 'https://via.placeholder.com/150', 'stock' => 8],
        (object) ['id' => 4, 'name' => 'Produk 4', 'description' => 'Deskripsi produk 4', 'price' => 300000, 'image' => 'https://via.placeholder.com/150', 'stock' => 3],
    ]);
    return view('welcome', compact('products'));
})->name('welcome');

// Daftar produk
Route::get('/products', function () {
    // Data dummy untuk produk dengan paginasi
    $products = new \Illuminate\Pagination\LengthAwarePaginator(
        [
            (object) ['id' => 1, 'name' => 'Produk 1', 'description' => 'Deskripsi produk 1', 'price' => 100000, 'image' => 'https://via.placeholder.com/150', 'stock' => 10],
            (object) ['id' => 2, 'name' => 'Produk 2', 'description' => 'Deskripsi produk 2', 'price' => 200000, 'image' => 'https://via.placeholder.com/150', 'stock' => 5],
            // Tambahkan lebih banyak jika perlu
        ],
        12, // Total item
        12, // Item per halaman
        1,  // Halaman saat ini
        ['path' => '/products']
    );
    return view('products.index', compact('products'));
})->name('products.index');

// Detail produk
Route::get('/products/{id}', function ($id) {
    // Data dummy untuk produk
    $product = (object) [
        'id' => $id,
        'name' => 'Produk ' . $id,
        'description' => 'Deskripsi untuk produk ' . $id,
        'price' => 100000 * $id,
        'image' => 'https://via.placeholder.com/150',
        'stock' => 10
    ];
    return view('products.show', compact('product'));
})->name('products.show');

// Daftar pesanan
Route::get('/orders', function () {
    // Data dummy untuk pesanan
    $orders = new \Illuminate\Pagination\LengthAwarePaginator(
        [
            (object) ['id' => 1, 'product' => (object) ['name' => 'Produk 1'], 'quantity' => 2, 'total_price' => 200000, 'status' => 'pending'],
            (object) ['id' => 2, 'product' => (object) ['name' => 'Produk 2'], 'quantity' => 1, 'total_price' => 150000, 'status' => 'paid'],
        ],
        10, // Total item
        10, // Item per halaman
        1,  // Halaman saat ini
        ['path' => '/orders']
    );
    return view('orders.index', compact('orders'));
})->name('orders.index');

// Detail pesanan
Route::get('/orders/{id}', function ($id) {
    // Data dummy untuk pesanan
    $order = (object) [
        'id' => $id,
        'product' => (object) ['name' => 'Produk ' . $id],
        'quantity' => 2,
        'total_price' => 200000,
        'status' => 'pending',
        'proof_file' => null
    ];
    return view('orders.show', compact('order'));
})->name('orders.show');

// Admin dashboard
Route::get('/admin/dashboard', function () {
    // Data dummy untuk dashboard
    $products = [
        (object) ['id' => 1, 'name' => 'Produk 1', 'price' => 100000, 'stock' => 10],
        (object) ['id' => 2, 'name' => 'Produk 2', 'price' => 200000, 'stock' => 5],
    ];
    $orders = [
        (object) ['id' => 1, 'product' => (object) ['name' => 'Produk 1'], 'quantity' => 2, 'total_price' => 200000, 'status' => 'pending'],
    ];
    return view('admin.dashboard', compact('products', 'orders'));
})->name('admin.dashboard');