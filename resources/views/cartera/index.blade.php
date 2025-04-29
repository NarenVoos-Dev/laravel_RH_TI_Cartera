@extends('layouts.app')
@section('title','Cartera')
@section('page-title','Bienvenido')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Carteras</h5>
        @can('crear cartera')
        <div>
            <a href="{{ route('reportes.carteras.index') }}" class="btn btn-outline-dark me-2">
                <i class="bx bx-bar-chart-alt"></i> Reportes de movimientos
            </a>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCarteraModal">
                <i class="bx bx-plus"></i> Nueva Cartera
            </button>
        </div>
        @endcan
    </div>
</div>

@can('ver cartera')
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="carterasTable" class="table align-middle table-hover table-bordered">
            <thead class="text-center table-light">
                <tr>
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Compañía del empleado</th>
                    <th>Compañía de la cartera</th>
                    <th>Concepto de cartera</th>
                    <th>Fecha de Cartera</th>
                    <th>Saldo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carteras as $cartera)
                <tr>
                    <td class="text-center">{{ $cartera->id }}</td>
                    <td class="text-center">{{ $cartera->employee->name }}</td>
                    <td class="text-center">{{ $cartera->company->name ?? 'Sin Empresa' }}</td>
                    <td class="text-center">{{ $cartera->companies->pluck('name')->first() ?? 'Sin Empresa' }}</td>
                    <td class="text-center">{{ $cartera->concept }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($cartera->issue_date)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $cartera->balance > 0 ? 'bg-danger' : 'bg-success' }}">
                            $ {{ number_format($cartera->balance, 0, ',', '.') }} <small>COP</small>
                        </span>
                    </td>

                    <td class="text-center">
                        @can('crear abonos')
                        <button class="btn btn-sm btn-light abonarBtn" data-id="{{ $cartera->id }}"
                            data-bs-toggle="modal" data-bs-target="#abonarModal" title="Abonar" data-bs-placement="top">
                            <i class="bx bx-wallet text-success"></i>
                        </button>
                        @endcan
                        <button class="btn btn-sm btn-light verHistorialBtn" data-id="{{ $cartera->id }}"
                            data-bs-toggle="modal" data-bs-target="#historialModal" title="Historial"
                            data-bs-toggle="tooltip">
                            <i class="bx bx-time text-info"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endcan

@include('cartera.modalCreate')
@include('cartera.modalEdit')
@include('cartera.modalAbonarCartera')
@include('cartera.modalHistorialCartera')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#carterasTable').DataTable({
        responsive: true,  // <-- Agregar esto
        order: [[0, 'desc']],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });


    //etiquetas de los botones de acción
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Seleccionar opciones de select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'Seleccione una opción',
        dropdownParent: $('#createCarteraForm')
    });


    //crear cartera
    $('#createCarteraForm').on('submit', function(e) {
        e.preventDefault();

        let formData = {
            employee_id: $('#employee_id').val(),
            issue_date: $('#issue_date').val(),
            concept: $('#concept').val(),
            total_amount: $('#total_amount').val(),
        };



        $.ajax({
            url: '/cartera',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                $('#createCarteraModal').modal('hide');
                Swal.fire('¡Cartera registrada!', '', 'success').then(() => location
                    .reload());
            },
            error: function(xhr) {
                $('#createCarteraModal').modal('hide');
                let mensaje = 'Error inesperado';

                try {
                    const response = JSON.parse(xhr.responseText);

                    if (response.errors) {
                        const errores = Object.values(response.errors).flat();
                        mensaje = errores[0];

                        switch (mensaje) {
                            case 'El campo employee_id es obligatorio.':
                                Swal.fire('Falta empleado',
                                    'Debes seleccionar un empleado.', 'warning');
                                break;
                            case 'El campo company_id es obligatorio.':
                                Swal.fire('Falta compañía',
                                    'Debes seleccionar una compañía.', 'warning');
                                break;
                            case 'El campo issue_date es obligatorio.':
                                Swal.fire('Falta fecha',
                                    'Debes seleccionar la fecha de emisión.', 'warning');
                                break;
                            case 'El campo total_amount es obligatorio.':
                                Swal.fire('Falta monto',
                                    'Ingresa el valor total de la cartera.', 'warning');
                                break;
                            default:
                                Swal.fire('Error', mensaje, 'error');
                                break;
                        }
                    } else if (response.message) {
                        mensaje = response.message;
                        Swal.fire('Error', mensaje, 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', 'No se pudo procesar la respuesta del servidor.',
                        'error');
                    console.error('Error inesperado:', e);
                }
            }


        });
    });

    // Establecer wallet_id al abrir el modal
    $('.abonarBtn').on('click', function() {
        let walletId = $(this).data('id');
        $('#wallet_id').val(walletId);

    });

    //crear abono
    $('#formAbonarCartera').on('submit', function(e) {
        e.preventDefault();

        let walletId = $('#wallet_id').val();
        let url = `/cartera/${walletId}/movements`;

        let formData = {
            wallet_id: walletId,
            payment_date: $('#payment_date').val(),
            amount: $('#amount').val(),
            description: $('#description').val(),
            status: $('#status').val()
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#abonarModal').modal('hide');
                Swal.fire('¡Abono registrado!', response.message, 'success').then(
                    () => {
                        location
                            .reload(); // Puedes reemplazar por actualizar solo la tabla
                    });
            },
            error: function(xhr) {
                $('#abonarModal').modal('hide');
                console.log('Error:', xhr);
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    let errores = xhr.responseJSON.errors;
                    let msg = Object.values(errores).flat().join('\n');
                    Swal.fire('Errores de validación', msg, 'warning');
                } else {
                    console.error(xhr.responseJSON || xhr);
                    Swal.fire('Error', 'No se pudo registrar el abono.', 'error');
                }
            }
        });
    });
    // Ver historial de movimientos
    $('.verHistorialBtn').on('click', function() {
        let walletId = $(this).data('id');

        $.ajax({
            url: `/cartera/${walletId}/movements`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#nombreEmpleado').text(response.employee);
                    $('#saldoInicial').text(response.total_amount.toLocaleString(
                        'es-CO'));
                    $('#saldoActual').text(response.balance.toLocaleString('es-CO'));

                    let rows = '';
                    response.movements.forEach(mov => {
                        rows += `
                            <tr>
                                <td>$ ${new Date(mov.payment_date).toLocaleDateString()}</td>
                                <td>$ ${parseInt(mov.amount).toLocaleString('es-CO')}</td>
                                <td> ${mov.description || '—'}</td>
                            </tr>`;
                    });

                    $('#historialBody').html(rows);
                } else {
                    Swal.fire('Error', 'No se pudo obtener el historial.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error de servidor al cargar el historial.',
                    'error');
            }
        });
    });


});
</script>
@endpush