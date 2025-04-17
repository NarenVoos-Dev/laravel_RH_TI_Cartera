@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de Nómina del Empleado</h2>

    <div class="mb-4 card">
        <div class="card-body">
            <h5><strong>Empleado:</strong> {{ $detail->employee->name }}</h5>
            <h5><strong>Cédula:</strong> {{ $detail->employee->document_identification }}</h5>
            <h5><strong>Período:</strong> {{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}</h5>
        </div>
    </div>
    <form action="{{ route('payroll_details.update_days', $detail->id) }}" method="POST" class="mb-4">
    @csrf
    @method('PATCH')

    <div class="row">
            <div class="col-md-4">
                <label for="days_worked" class="form-label">Días trabajados</label>
                <input type="number" name="days_worked" id="days_worked" class="form-control" value="{{ $detail->days_worked }}" min="0" max="30" required>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Actualizar y Recalcular</button>
            </div>
        </div>
    </form>

    <div class="row">
        {{-- Devengados --}}
        <div class="col-md-6">
            <h4>Devengados</h4>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail->items->where('type', 'earning') as $item)
                        <tr>
                            <td>{{ $item->description ?? $item->concept->name }}</td>
                            <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Deducciones --}}
        <div class="col-md-6">
            <h4>Deducciones</h4>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail->items->where('type', 'deduction') as $item)
                        <tr>
                            <td>{{ $item->description ?? $item->concept->name }}</td>
                            <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <h4>Total Devengado: ${{ number_format($detail->total_earnings, 0, ',', '.') }}</h4>
        <h4>Total Deducciones: ${{ number_format($detail->total_deductions, 0, ',', '.') }}</h4>
        <h3 class="text-success">Neto a Pagar: ${{ number_format($detail->net_salary, 0, ',', '.') }}</h3>
    </div>

    <a href="{{ route('payrolls.show', $detail->payroll_id) }}" class="mt-3 btn btn-secondary">Volver a nómina</a>
</div>
@endsection
