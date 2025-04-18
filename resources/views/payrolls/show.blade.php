@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalle de Nómina</h5>
        <div class="gap-2 d-flex">
            @if ($payroll->status !== 'cerrada')
                <form action="{{ route('payrolls.close', $payroll->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cerrar esta nómina? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-danger" title="Cerrar nómina">
                        <i class="bx bx-lock"></i> Cerrar Nómina
                    </button>
                </form>
            @endif

            <a href="{{ route('payrolls.export_excel', $payroll->id) }}" class="btn btn-outline-success">
                <i class="bx bx-file"></i> Exportar Excel
            </a>

            <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="p-4 mt-4 card">
    <div class="mb-3">
        <p><strong>Empresa:</strong> {{ $payroll->company->name }}</p>
        <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payroll->end_date)->format('d/m/Y') }}</p>
        <p><strong>Fecha de pago:</strong> {{ \Carbon\Carbon::parse($payroll->payment_date)->format('d/m/Y') }}</p>
        <p>
            <strong>Estado:</strong>
            <span class="badge bg-{{ $payroll->status == 'cerrada' ? 'success' : 'warning' }}">
                {{ ucfirst($payroll->status) }}
            </span>
        </p>
    </div>

    <h5 class="mt-3">Empleados incluidos</h5>

    <div class="table-responsive text-nowrap">
        <table class="table align-middle table-bordered table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th>Empleado</th>
                    <th>Cédula</th>
                    <th>Devengado</th>
                    <th>Deducciones</th>
                    <th>Total a pagar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payroll->details as $detail)
                    <tr>
                        <td class="text-center">{{ $detail->employee->name }}</td>
                        <td class="text-center">{{ $detail->employee->document_identification }}</td>
                        <td class="text-center">${{ number_format($detail->total_earnings, 0, ',', '.') }}</td>
                        <td class="text-center">${{ number_format($detail->total_deductions, 0, ',', '.') }}</td>
                        <td class="text-center"><strong>${{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
                        <td class="text-center">
                            <a href="{{ route('payroll_details.show', $detail->id) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                                <i class="bx bx-show-alt"></i> Detalle
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay empleados registrados en esta nómina.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
