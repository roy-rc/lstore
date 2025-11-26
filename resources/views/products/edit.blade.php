@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="page-header">
    <h1>Editar Producto</h1>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $product->name) }}" 
                required
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="form-control"
            >{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Precio *</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    step="0.01"
                    value="{{ old('price', $product->price) }}" 
                    required
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="stock">Stock *</label>
                <input 
                    type="number" 
                    id="stock" 
                    name="stock" 
                    value="{{ old('stock', $product->stock) }}" 
                    required
                    class="form-control"
                >
            </div>
        </div>

        <div class="form-group">
            <label>Categorías</label>
            <div class="checkbox-group">
                @foreach($categories as $category)
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="categories[]" 
                            value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                        >
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
