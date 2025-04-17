@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Historial de Nóminas</h2>

    <a href="{{ route('payrolls.create') }}" class="mb-3 btn btn-primary">Crear nueva nómina</a>

    <table class="table table-bordered">
        <thead>
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
                    <td>{{ $payroll->company->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payroll->end_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($payroll->payment_date)->format('d/m/Y') }}</td>
                    <td><span class="badge bg-{{ $payroll->status == 'cerrada' ? 'success' : 'warning' }}">{{ ucfirst($payroll->status) }}</span></td>
                    <td>
                        <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-info">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
