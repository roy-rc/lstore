@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="page-header">
    <h1>Categorías</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Crear Categoría</a>
</div>

<div class="search-box">
    <form method="GET" action="{{ route('categories.index') }}">
        <input 
            type="text" 
            name="search" 
            placeholder="Buscar por nombre..." 
            value="{{ $search }}"
            class="search-input"
        >
        <button type="submit" class="btn btn-secondary">Buscar</button>
        @if($search)
            <a href="{{ route('categories.index') }}" class="btn btn-outline">Limpiar</a>
        @endif
    </form>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>N° Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? 'N/A' }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td class="actions">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay categorías disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $categories->links() }}
</div>
@endsection
