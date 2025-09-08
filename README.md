# Syneps Marketplace - Laravel 12 + Tailwind CSS

## 🚀 Frontend Development (COMPLETED)

Frontend telah selesai dikembangkan dengan fitur-fitur berikut:
- Authentication pages (Login, Register)
- Product listing dan detail
- Order management
- Admin dashboard
- Responsive design dengan Tailwind CSS
- Reusable components

## 📋 Backend Development Tasks

### Database Schema
Silakan buat migrasi untuk tabel berikut:

#### 1. Users Table
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->enum('role', ['user', 'admin'])->default('user');
    $table->rememberToken();
    $table->timestamps();
});
```

#### 2. Products Table
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->decimal('price', 10, 2);
    $table->string('image')->nullable();
    $table->integer('stock')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### 3. Orders Table
```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->integer('quantity')->default(1);
    $table->decimal('total_price', 10, 2);
    $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
    $table->string('proof_file')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

### Required Routes
Tambahkan routes berikut di `web.php`:

```php
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [ProductController::class, 'welcome'])->name('welcome');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // User routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/upload-proof', [OrderController::class, 'uploadProof'])->name('orders.upload-proof');
    });
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Product management
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        
        // Order management
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    });
});
```

### Required Controllers

#### 1. AuthController
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/products');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']]);

        return redirect('/products');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
```

#### 2. ProductController
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function welcome()
    {
        $products = Product::where('is_active', true)->take(4)->get();
        return view('welcome', compact('products'));
    }

    public function index()
    {
        $products = Product::where('is_active', true)->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil dihapus!');
    }
}
```

#### 3. OrderController
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        if ($product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi']);
        }

        $totalPrice = $product->price * $validated['quantity'];

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
        ]);

        // Kurangi stok
        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'proof_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        if ($order->proof_file) {
            Storage::disk('public')->delete($order->proof_file);
        }

        $path = $request->file('proof_file')->store('proofs', 'public');
        
        $order->update([
            'proof_file' => $path,
            'status' => 'paid'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
```

### Required Models

#### User Model (Update existing)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
```

#### Product Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
```

#### Order Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'proof_file',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
```

### Middleware Setup

#### RoleMiddleware
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
```

Register middleware di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### File Storage Setup
Jalankan command berikut:
```bash
php artisan storage:link
```

### Installation Steps
1. Clone repository
2. Copy `.env.example` to `.env`
3. Configure database di `.env`
4. Run: `composer install`
5. Run: `php artisan key:generate`
6. Run: `php artisan migrate`
7. Run: `php artisan storage:link`
8. Run: `php artisan serve`

### Default Admin User (Optional)
Buat seeder untuk admin:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@syneps.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
```

## 📱 Frontend Features Included
- ✅ Responsive design
- ✅ Authentication pages
- ✅ Product listing & detail
- ✅ Order management
- ✅ Admin dashboard
- ✅ File upload interface
- ✅ Reusable components

## 🎨 Design System
- Tailwind CSS 4.1.13
- Clean & modern interface
- Consistent color scheme
- Mobile-first approach

## 📁 Project Structure
```
resources/views/
├── components/          # Reusable components
├── auth/               # Authentication pages
├── products/           # Product pages
├── orders/            # Order pages
├── admin/             # Admin dashboard
└── layouts/           # Layout templates
```

**Happy coding! 🚀**