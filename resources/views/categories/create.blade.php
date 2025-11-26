@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')
<div class="page-header">
    <h1>Crear Categoría</h1>
</div>

<div class="form-container">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nombre *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
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
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Crear Categoría</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
