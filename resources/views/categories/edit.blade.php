@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<div class="page-header">
    <h1>Editar Categoría</h1>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nombre *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $category->name) }}" 
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
            >{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
