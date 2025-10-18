# Guía Completa: Desarrollo de Ecommerce con Laravel 12 - Paso a Paso

## Índice

1. [Análisis del Proyecto](#análisis-del-proyecto)
2. [Preparación del Entorno](#preparación-del-entorno)
3. [Fase 1: Configuración de Base de Datos](#fase-1-configuración-de-base-de-datos)
4. [Fase 2: Modelos y Relaciones](#fase-2-modelos-y-relaciones)
5. [Fase 3: Sistema de Autenticación](#fase-3-sistema-de-autenticación)
6. [Fase 4: Panel Administrativo](#fase-4-panel-administrativo)
7. [Fase 5: Frontend del Ecommerce](#fase-5-frontend-del-ecommerce)
8. [Fase 6: Carrito de Compras](#fase-6-carrito-de-compras)
9. [Fase 7: Sistema de Órdenes](#fase-7-sistema-de-órdenes)
10. [Fase 8: Toques Finales](#fase-8-toques-finales)

## Análisis del Proyecto

### Entidades Principales
- **Customer**: Usuario final que compra productos
- **Product**: Productos disponibles en la tienda
- **Category**: Categorías para organizar productos
- **Quote**: Carrito de compras (items temporales)
- **Order**: Órdenes de compra finalizadas
- **User**: Administradores del sistema

### Relaciones de Base de Datos
- **Many-to-Many**: Product ↔ Category
- **Many-to-Many**: Order ↔ Product (con pivot table para qty, price)
- **One-to-Many**: Customer → Quote
- **One-to-Many**: Customer → Order

## Preparación del Entorno

Según tu configuración actual, ya tienes:
- Laravel 12.34.0
- Docker con MySQL
- Dominio local: lstore.local

### Verificar Configuración Actual

```bash
# Verificar que todo esté funcionando
./vendor/bin/sail exec laravel.test php artisan --version
./vendor/bin/sail exec laravel.test php artisan migrate:status
```

## Fase 1: Configuración de Base de Datos

### 1.1 Crear Migraciones

Vamos a crear todas las migraciones necesarias:

```bash
# Generar migraciones
./vendor/bin/sail exec laravel.test php artisan make:migration create_customers_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_products_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_categories_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_quotes_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_orders_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_product_category_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_order_product_table
```

### 1.2 Definir Esquema de Migraciones

**database/migrations/xxxx_create_customers_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
```

**database/migrations/xxxx_create_products_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('qty')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

**database/migrations/xxxx_create_categories_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

**database/migrations/xxxx_create_quotes_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
```

**database/migrations/xxxx_create_orders_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
```

**database/migrations/xxxx_create_product_category_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['product_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
```

**database/migrations/xxxx_create_order_product_table.php**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('price', 10, 2); // Precio al momento de la compra
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
```

### 1.3 Ejecutar Migraciones

```bash
./vendor/bin/sail exec laravel.test php artisan migrate
```

## Fase 2: Modelos y Relaciones

### 2.1 Crear Modelos

```bash
# Crear modelos
./vendor/bin/sail exec laravel.test php artisan make:model Customer
./vendor/bin/sail exec laravel.test php artisan make:model Product
./vendor/bin/sail exec laravel.test php artisan make:model Category
./vendor/bin/sail exec laravel.test php artisan make:model Quote
./vendor/bin/sail exec laravel.test php artisan make:model Order
```

### 2.2 Definir Modelos y Relaciones

**app/Models/Customer.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
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

    // Relaciones
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessor para nombre completo
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }
}
```

**app/Models/Product.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'title',
        'description',
        'short_description',
        'image',
        'price',
        'qty',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    // Relaciones
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('qty', 'price')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
}
```

**app/Models/Category.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    // Relaciones
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
```

**app/Models/Quote.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'qty',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
```

**app/Models/Order.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('qty', 'price')
                    ->withTimestamps();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
```

## Fase 3: Sistema de Autenticación

### 3.1 Configurar Guards Múltiples

**config/auth.php** - Agregar al array de guards:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'customer' => [
        'driver' => 'session',
        'provider' => 'customers',
    ],
],
```

**config/auth.php** - Agregar al array de providers:
```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'customers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Customer::class,
    ],
],
```

**config/auth.php** - Agregar al array de passwords:
```php
'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ],
    'customers' => [
        'provider' => 'customers',
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ],
],
```

### 3.2 Crear Controladores de Autenticación

```bash
# Crear controladores
./vendor/bin/sail exec laravel.test php artisan make:controller Auth/CustomerAuthController
./vendor/bin/sail exec laravel.test php artisan make:controller Auth/AdminAuthController
```

**app/Http/Controllers/Auth/CustomerAuthController.php**
```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
```

### 3.3 Crear Rutas de Autenticación

**routes/web.php**
```php
<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación para customers
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

// Rutas de autenticación para admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Rutas protegidas del admin
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});
```

## Continuará...

Esta es la primera parte de la guía. Continúo con las siguientes fases en la siguiente sección del documento.

---

*Esta guía continuará con:*
- Fase 4: Panel Administrativo con CRUD
- Fase 5: Frontend del Ecommerce  
- Fase 6: Carrito de Compras
- Fase 7: Sistema de Órdenes
- Fase 8: Toques Finales

*Total estimado: ~50 páginas de documentación detallada*