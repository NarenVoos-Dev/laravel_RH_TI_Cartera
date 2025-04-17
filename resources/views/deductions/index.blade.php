@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Catálogo de Deducciones</h2>

    <a href="{{ route('deductions.create') }}" class="mb-3 btn btn-primary">Nueva deducción</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Porcentaje</th>
                <th>¿Obligatoria?</th>
                <th>¿Editable?</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deductions as $deduction)
                <tr>
                    <td>{{ $deduction->name }}</td>
                    <td>{{ $deduction->percentage ?? '—' }}%</td>
                    <td>{{ $deduction->is_mandatory ? 'Sí' : 'No' }}</td>
                    <td>{{ $deduction->is_editable ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('deductions.edit', $deduction) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('deductions.destroy', $deduction) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta deducción?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
