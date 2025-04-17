@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Deducción</h2>

    <form action="{{ route('deductions.update', $deduction) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del concepto</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $deduction->name }}" required>
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Porcentaje (opcional)</label>
            <input type="number" name="percentage" id="percentage" class="form-control" step="0.01" value="{{ $deduction->percentage }}">
        </div>

        <div class="mb-2 form-check">
            <input class="form-check-input" type="checkbox" name="is_mandatory" id="is_mandatory" {{ $deduction->is_mandatory ? 'checked' : '' }}>
            <label class="form-check-label" for="is_mandatory">
                ¿Es obligatoria?
            </label>
        </div>

        <div class="mb-4 form-check">
            <input class="form-check-input" type="checkbox" name="is_editable" id="is_editable" {{ $deduction->is_editable ? 'checked' : '' }}>
            <label class="form-check-label" for="is_editable">
                ¿Es editable?
            </label>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('deductions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
