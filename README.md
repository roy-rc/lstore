# 🛒 Laravel Store

Sistema de gestión de productos y categorías con relación muchos a muchos (M:N).

## 📋 Características

- ✅ CRUD completo de Productos
- ✅ CRUD completo de Categorías
- ✅ Relación M:N (muchos a muchos) entre productos y categorías
- ✅ Búsqueda por nombre en ambas entidades
- ✅ Paginación de resultados
- ✅ Validación de formularios
- ✅ Mensajes flash de éxito/error
- ✅ Diseño responsive con CSS puro
- ✅ Interfaz amigable e intuitiva

## 🛠️ Tecnologías

- **PHP 8.x**
- **Laravel 11.x**
- **MySQL**
- **Blade Templates**
- **CSS puro** (sin frameworks)

## 📦 Instalación

### Requisitos previos

- PHP >= 8.2
- Composer
- MySQL
- Apache/Nginx o servidor web

### Pasos de instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/roy-rc/lstore.git
cd lstore
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

Editar el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lstore
DB_USERNAME=root
DB_PASSWORD=
```

5. **Crear la base de datos**
```sql
CREATE DATABASE lstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Ejecutar migraciones**
```bash
php artisan migrate
```

7. **Cargar datos de prueba (opcional)**
```bash
php artisan db:seed
```

8. **Ejecutar el servidor**
```bash
php artisan serve
```

La aplicación estará disponible en: **http://127.0.0.1:8000**

## 📁 Estructura del Proyecto

### Modelos
- **Product** (`app/Models/Product.php`)
  - Campos: name, description, price, stock
  - Relación: belongsToMany(Category)

- **Category** (`app/Models/Category.php`)
  - Campos: name, description
  - Relación: belongsToMany(Product)

### Controladores
- **ProductController** (`app/Http/Controllers/Frontend/ProductController.php`)
- **CategoryController** (`app/Http/Controllers/Frontend/CategoryController.php`)

### Rutas
```php
Route::get('/', ...) // Home
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
```

### Vistas
```
resources/views/
├── layouts/
│   └── app.blade.php
├── home.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── categories/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

## 🎯 Funcionalidades

### Productos
- Listar todos los productos con paginación
- Buscar productos por nombre
- Crear nuevo producto con múltiples categorías
- Editar producto y sus categorías
- Eliminar producto

### Categorías
- Listar todas las categorías con contador de productos
- Buscar categorías por nombre
- Crear nueva categoría
- Editar categoría
- Eliminar categoría

## 🎨 Diseño

El proyecto incluye un diseño responsive personalizado con:
- Sistema de grid flexible
- Navbar con navegación
- Formularios estilizados
- Tablas con efectos hover
- Botones con diferentes estados
- Alerts de éxito/error
- Compatible con dispositivos móviles

## 📝 Base de Datos

### Tablas principales
- `products` - Almacena información de productos
- `categories` - Almacena categorías
- `product_category` - Tabla pivote para relación M:N

## 🔒 Validación

Los formularios incluyen validación tanto del lado del cliente como del servidor:
- Campos requeridos marcados con *
- Validación de tipos de datos (precio, stock)
- Mensajes de error claros
- Confirmación antes de eliminar

## 🚀 Uso

1. Accede a la página principal en **http://127.0.0.1:8000**
2. Navega a **Productos** o **Categorías**
3. Usa el buscador para filtrar por nombre
4. Haz clic en **Crear** para agregar nuevos registros
5. Usa los botones **Editar** o **Eliminar** para gestionar registros

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
