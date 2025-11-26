@extends('layouts.app')

@section('title', 'Inicio - Laravel Store')

@section('content')
<div class="home-hero">
    <h1>Bienvenido a Laravel Store</h1>
    <p>Gestiona tus productos y categorías fácilmente</p>
</div>

<div class="home-cards">
    <div class="card">
        <div class="card-icon">📦</div>
        <h2>Productos</h2>
        <p>Administra tu catálogo de productos con precios, stock y más.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Ver Productos</a>
    </div>

    <div class="card">
        <div class="card-icon">🏷️</div>
        <h2>Categorías</h2>
        <p>Organiza tus productos en categorías para facilitar la navegación.</p>
        <a href="{{ route('categories.index') }}" class="btn btn-primary">Ver Categorías</a>
    </div>
</div>
@endsection
