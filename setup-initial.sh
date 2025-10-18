#!/bin/bash

# ========================================
# Script de Setup Inicial - Laravel Ecommerce
# Ejecutar desde el directorio raíz del proyecto
# ========================================

echo "🚀 Iniciando configuración del proyecto Laravel Ecommerce..."

# 1. Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "❌ Error: No se encontró el archivo artisan. Asegúrate de estar en el directorio raíz de Laravel."
    exit 1
fi

echo "✅ Directorio de Laravel encontrado"

# 2. Crear las migraciones
echo "📝 Creando migraciones..."
./vendor/bin/sail exec laravel.test php artisan make:migration create_customers_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_products_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_categories_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_quotes_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_orders_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_product_category_table
./vendor/bin/sail exec laravel.test php artisan make:migration create_order_product_table

echo "✅ Migraciones creadas"

# 3. Crear los modelos
echo "🏗️ Creando modelos..."
./vendor/bin/sail exec laravel.test php artisan make:model Customer
./vendor/bin/sail exec laravel.test php artisan make:model Product
./vendor/bin/sail exec laravel.test php artisan make:model Category
./vendor/bin/sail exec laravel.test php artisan make:model Quote
./vendor/bin/sail exec laravel.test php artisan make:model Order

echo "✅ Modelos creados"

# 4. Crear controladores
echo "🎮 Creando controladores..."
./vendor/bin/sail exec laravel.test php artisan make:controller Auth/CustomerAuthController
./vendor/bin/sail exec laravel.test php artisan make:controller Auth/AdminAuthController
./vendor/bin/sail exec laravel.test php artisan make:controller Admin/DashboardController
./vendor/bin/sail exec laravel.test php artisan make:controller Admin/ProductController --resource
./vendor/bin/sail exec laravel.test php artisan make:controller Admin/CategoryController --resource
./vendor/bin/sail exec laravel.test php artisan make:controller Admin/CustomerController --resource
./vendor/bin/sail exec laravel.test php artisan make:controller Admin/OrderController --resource
./vendor/bin/sail exec laravel.test php artisan make:controller Frontend/HomeController
./vendor/bin/sail exec laravel.test php artisan make:controller Frontend/ProductController
./vendor/bin/sail exec laravel.test php artisan make:controller Frontend/CategoryController
./vendor/bin/sail exec laravel.test php artisan make:controller Frontend/CartController
./vendor/bin/sail exec laravel.test php artisan make:controller Frontend/CheckoutController

echo "✅ Controladores creados"

# 5. Crear carpetas para vistas
echo "📁 Creando estructura de vistas..."
mkdir -p resources/views/auth/customer
mkdir -p resources/views/admin/dashboard
mkdir -p resources/views/admin/products
mkdir -p resources/views/admin/categories
mkdir -p resources/views/admin/customers
mkdir -p resources/views/admin/orders
mkdir -p resources/views/frontend/home
mkdir -p resources/views/frontend/products
mkdir -p resources/views/frontend/categories
mkdir -p resources/views/frontend/cart
mkdir -p resources/views/layouts

echo "✅ Estructura de vistas creada"

# 6. Crear seeders
echo "🌱 Creando seeders..."
./vendor/bin/sail exec laravel.test php artisan make:seeder UserSeeder
./vendor/bin/sail exec laravel.test php artisan make:seeder CategorySeeder
./vendor/bin/sail exec laravel.test php artisan make:seeder ProductSeeder

echo "✅ Seeders creados"

# 7. Crear factories
echo "🏭 Creando factories..."
./vendor/bin/sail exec laravel.test php artisan make:factory CustomerFactory
./vendor/bin/sail exec laravel.test php artisan make:factory ProductFactory
./vendor/bin/sail exec laravel.test php artisan make:factory CategoryFactory

echo "✅ Factories creados"

# 8. Crear middlewares personalizados
echo "🛡️ Creando middlewares..."
./vendor/bin/sail exec laravel.test php artisan make:middleware CustomerAuth
./vendor/bin/sail exec laravel.test php artisan make:middleware AdminAuth

echo "✅ Middlewares creados"

# 9. Mostrar resumen
echo ""
echo "🎉 ¡Setup inicial completado!"
echo ""
echo "📋 Resumen de lo que se creó:"
echo "   ✓ 7 migraciones"
echo "   ✓ 5 modelos"
echo "   ✓ 12 controladores"
echo "   ✓ Estructura de vistas"
echo "   ✓ 3 seeders"
echo "   ✓ 3 factories"
echo "   ✓ 2 middlewares"
echo ""
echo "🔄 Siguientes pasos:"
echo "   1. Editar las migraciones con los campos definidos en la guía"
echo "   2. Configurar los modelos y sus relaciones"
echo "   3. Configurar los guards de autenticación"
echo "   4. Ejecutar las migraciones"
echo ""
echo "📖 Consulta la guía completa para continuar con el desarrollo"
echo "💡 Recuerda: sigue las fases en orden para mejores resultados"

