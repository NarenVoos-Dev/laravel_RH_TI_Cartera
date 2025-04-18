@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Desprendibles</h2>

    @if($payrollDetails->isEmpty())
        <div class="alert alert-info">Aún no tienes colillas registradas.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Empleados</th>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Fecha de pago</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrollDetails as $detail)
                    <tr>
                        <td>{{ $detail->employee->name }}</td>
                        <td>{{ $detail->payroll->company->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->payroll->payment_date)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $detail->payroll->status === 'cerrada' ? 'success' : 'secondary' }}">
                                {{ ucfirst($detail->payroll->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('desprendibles.export_pdf', $detail->id) }}" class="btn btn-sm btn-dark" target="_blank">
                                📄 Ver PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
