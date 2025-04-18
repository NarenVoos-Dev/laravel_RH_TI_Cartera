@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalle de Nómina del Empleado</h5>
        <div class="gap-2 d-flex">
            <a href="{{ route('payroll_details.export_pdf', $detail->id) }}" target="_blank" class="btn btn-outline-dark">
                <i class="bx bx-download"></i> Descargar PDF
            </a>
            <a href="{{ route('payrolls.show', $detail->payroll_id) }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Volver
            </a>
        </div>
    </div>

    <div class="card-body">
        <p><strong>Empleado:</strong> {{ $detail->employee->name }}</p>
        <p><strong>Cédula:</strong> {{ $detail->employee->document_identification }}</p>
        <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}</p>

        @if ($detail->payroll->status === 'cerrada')
            <div class="alert alert-warning">
                Esta nómina ha sido <strong>cerrada</strong>. No puedes hacer modificaciones.
            </div>
        @endif

        {{-- Días trabajados --}}
        @if ($detail->payroll->status !== 'cerrada')
            <form action="{{ route('payroll_details.update_days', $detail->id) }}" method="POST" class="mb-4">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-4">
                        <label for="days_worked" class="form-label">Días trabajados</label>
                        <input type="number" name="days_worked" id="days_worked" class="form-control"
                            value="{{ $detail->days_worked }}" min="0" max="30" required>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-refresh"></i> Recalcular
                        </button>
                    </div>
                </div>
            </form>

            {{-- Botón para agregar concepto --}}
            <button type="button" class="mb-3 btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarConcepto">
                <i class="bx bx-plus"></i> Agregar concepto manual
            </button>
        @else
            <p><strong>Días trabajados:</strong> {{ $detail->days_worked }}</p>
        @endif

        <div class="row">
            {{-- Devengados --}}
            <div class="col-md-6">
                <h5>Devengados</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table align-middle table-sm table-bordered">
                        <thead class="text-center table-light">
                            <tr>
                                <th>Concepto</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail->items->where('type', 'earning') as $item)
                            <tr>
                                <td>{{ $item->description ?? $item->concept->name }}</td>
                                <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($detail->payroll->status !== 'cerrada')
                                        <form action="{{ route('payroll_detail_items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este concepto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Deducciones --}}
            <div class="col-md-6">
                <h5>Deducciones</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table align-middle table-sm table-bordered">
                        <thead class="text-center table-light">
                            <tr>
                                <th>Concepto</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail->items->where('type', 'deduction') as $item)
                            <tr>
                                <td>{{ $item->description ?? $item->concept->name }}</td>
                                <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($detail->payroll->status !== 'cerrada')
                                        <form action="{{ route('payroll_detail_items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este concepto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Totales --}}
        <div class="mt-4">
            <h5>Total Devengado: ${{ number_format($detail->total_earnings, 0, ',', '.') }}</h5>
            <h5>Total Deducciones: ${{ number_format($detail->total_deductions, 0, ',', '.') }}</h5>
            <h4 class="text-success">Neto a Pagar: ${{ number_format($detail->net_salary, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

{{-- Modal solo si no está cerrada --}}
@if ($detail->payroll->status !== 'cerrada')
    @include('payrolls.payroll_details.modalConcept')
@endif
@endsection
