@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Mis Desprendibles</h4>
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
    @if($payrollDetails->isEmpty())
        <div class="py-4 text-center alert alert-info">
            <i class="bx bx-info-circle fs-2"></i><br>
            Aún no tienes colillas registradas.
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover table-striped" id="desprendiblesTable">
                    <thead class="text-center table-light">
                        <tr>
                            <th> Empleado</th>
                            <th> Empresa</th>
                            <th> Período</th>
                            <th> Pago</th>
                            <th> Estado</th>
                            <th> Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrollDetails as $detail)
                            <tr class="text-center">
                                <td>{{ $detail->employee->name }}</td>
                                <td>{{ $detail->payroll->company->name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($detail->payroll->payment_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $detail->payroll->status === 'cerrada' ? 'success' : 'warning' }}">
                                        {{ ucfirst($detail->payroll->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('desprendibles.export_pdf', $detail->id) }}" 
                                       class="btn btn-sm btn-outline-dark" 
                                       target="_blank" title="Descargar PDF" data-bs-toggle="tooltip" data-bs-placement="top">
                                        <i class="bx bx-download"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Datatables
    $('#desprendiblesTable').DataTable({
        "order": [
            [0, "desc"]
        ], // Ordena por la primera columna en orden descendente
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    //etiquetas de los botones de acción
    $('[data-bs-toggle="tooltip"]').tooltip();

});
</script>
@endpush
