@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de Nómina</h2>

    <div class="mb-4 card">
        <div class="card-body">
            <h5><strong>Empresa:</strong> {{ $payroll->company->name }}</h5>
            <h5><strong>Período:</strong> {{ \Carbon\Carbon::parse($payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payroll->end_date)->format('d/m/Y') }}</h5>
            <h5><strong>Fecha de pago:</strong> {{ \Carbon\Carbon::parse($payroll->payment_date)->format('d/m/Y') }}</h5>
            <h5><strong>Estado:</strong> <span class="badge bg-{{ $payroll->status == 'cerrada' ? 'success' : 'warning' }}">{{ ucfirst($payroll->status) }}</span></h5>
        </div>
    </div>

    <h4>Empleados incluidos</h4>

    <table class="table table-bordered">
        <thead>
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
                    <td>{{ $detail->employee->name }}</td>
                    <td>{{ $detail->employee->document_identification }}</td>
                    <td>${{ number_format($detail->total_earnings, 0, ',', '.') }}</td>
                    <td>${{ number_format($detail->total_deductions, 0, ',', '.') }}</td>
                    <td><strong>${{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
                    <td>
                        <a href="{{ route('payroll_details.show', $detail->id) }}" class="btn btn-sm btn-info">Detalle</a>
                        {{-- Podrías agregar botón para "Agregar Novedades" aquí --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay empleados registrados en esta nómina.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
