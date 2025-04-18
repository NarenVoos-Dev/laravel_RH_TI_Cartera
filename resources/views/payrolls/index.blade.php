@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Historial de Nóminas</h5>
        <a href="{{ route('payrolls.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Crear nueva nómina
        </a>
    </div>
</div>

<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table class="table align-middle table-bordered table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Fecha de Pago</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $payroll)
                    <tr>
                        <td class="text-center">{{ $payroll->company->name }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($payroll->start_date)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($payroll->end_date)->format('d/m/Y') }}
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($payroll->payment_date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $payroll->status === 'cerrada' ? 'success' : 'warning' }}">
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('payrolls.show', $payroll->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-show-alt"></i> Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
