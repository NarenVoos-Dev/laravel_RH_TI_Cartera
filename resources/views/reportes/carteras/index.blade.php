@extends('layouts.app')
@section('title','Reporte de movimientos de cartera')

@section('content')
<div class="mb-4 card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Reporte de Movimientos</h5>
        <a href="{{ route('cartera.index') }}" class="btn btn-outline-dark">
            <i class="bx bx-arrow-back"></i> Volver
        </a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.carteras.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="employee_id" class="form-label">Empleado</label>
                <select name="employee_id" class="form-select">
                    <option value="">-- Todos --</option>
                    @foreach ($empleados as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="company_id" class="form-label">Compañía</label>
                <select name="company_id" class="form-select">
                    <option value="">-- Todas --</option>
                    @foreach ($companias as $comp)
                    <option value="{{ $comp->id }}" {{ request('company_id') == $comp->id ? 'selected' : '' }}>
                        {{ $comp->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Rango de fechas</label>
                <div class="d-flex">
                    <input type="date" name="fecha_inicio" class="form-control me-2"
                        value="{{ request('fecha_inicio') }}">
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2"><i class="bx bx-search"></i> Filtrar</button>
                <a href="{{ route('reportes.carteras.index') }}" class="btn btn-secondary me-2"><i class="bx bx-reset"></i>
                    Limpiar</a>
                <a href="{{ route('reportes.carteras.export', request()->query()) }}" class="btn btn-success me-2"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar a Excel">
            
                    <i class="bx bx-download"></i> Excel
                </a>
                <a href="{{ route('reportes.carteras.pdf', request()->all()) }}" class="btn btn-danger" target="_blank"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Exportar PDF">
                <i class="bx bx-file"></i>PDF
                
                </a>

            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table text-center table-hover table-bordered" id="movimientosTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Compañía</th>
                    <th>Valor</th>
                    <th>Fecha</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $index => $mov)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mov->wallet->employee->name ?? 'No asignado' }}</td>
                    <td>{{ $mov->wallet->company->name ?? 'No asignado' }}</td>
                    <td>${{ number_format($mov->amount, 0, ',', '.') }}</td>
                    <td>{{ $mov->created_at->format('Y-m-d') }}</td>
                    <td>{{ $mov->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush