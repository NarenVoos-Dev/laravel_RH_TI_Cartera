@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Catálogo de Devengados</h2>

    <a href="{{ route('earnings.create') }}" class="mb-3 btn btn-primary">Nuevo devengado</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Valor por defecto</th>
                <th>¿Editable?</th>
                <th>¿Tributable?</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($earnings as $earning)
                <tr>
                    <td>{{ $earning->name }}</td>
                    <td>{{ $earning->default_value ?? '—' }}</td>
                    <td>{{ $earning->is_editable ? 'Sí' : 'No' }}</td>
                    <td>{{ $earning->is_taxable ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('earnings.edit', $earning) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('earnings.destroy', $earning) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este concepto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
