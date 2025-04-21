@extends('layouts.app')

@section('title','Editar Permisos')
@section('page-title','Permisos de Rol')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Permisos para el Rol: <strong>{{ $role->name }}</strong></h5>
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Volver
        </a>
    </div>
</div>

<div class="p-4 mt-3 card">
    <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($permissions as $permission)
                <div class="mb-2 col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" 
                               value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ ucfirst($permission->name) }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
