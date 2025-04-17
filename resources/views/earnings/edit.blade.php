@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Devengado</h2>

    <form action="{{ route('earnings.update', $earning) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del concepto</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $earning->name }}" required>
        </div>

        <div class="mb-3">
            <label for="default_value" class="form-label">Valor por defecto (opcional)</label>
            <input type="number" name="default_value" id="default_value" class="form-control" step="0.01" value="{{ $earning->default_value }}">
        </div>

        <div class="mb-2 form-check">
            <input class="form-check-input" type="checkbox" name="is_editable" id="is_editable" {{ $earning->is_editable ? 'checked' : '' }}>
            <label class="form-check-label" for="is_editable">
                ¿Es editable al liquidar?
            </label>
        </div>

        <div class="mb-4 form-check">
            <input class="form-check-input" type="checkbox" name="is_taxable" id="is_taxable" {{ $earning->is_taxable ? 'checked' : '' }}>
            <label class="form-check-label" for="is_taxable">
                ¿Afecta impuestos/retención?
            </label>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('earnings.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
