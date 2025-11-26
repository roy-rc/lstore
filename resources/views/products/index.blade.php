@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="page-header">
    <h1>Productos</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Crear Producto</a>
</div>

<div class="search-box">
    <form method="GET" action="{{ route('products.index') }}">
        <input 
            type="text" 
            name="search" 
            placeholder="Buscar por nombre..." 
            value="{{ $search }}"
            class="search-input"
        >
        <button type="submit" class="btn btn-secondary">Buscar</button>
        @if($search)
            <a href="{{ route('products.index') }}" class="btn btn-outline">Limpiar</a>
        @endif
    </form>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categorías</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @foreach($product->categories as $category)
                            <span class="badge">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td class="actions">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay productos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $products->links() }}
</div>
@endsection
