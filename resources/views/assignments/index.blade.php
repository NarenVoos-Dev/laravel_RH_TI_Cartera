@extends('layouts.app')
@section('title','Asignaciones')
@section('page-title','Bienvenido')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Asignaciones de empleados</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAssignmentModal">
            <i class="bx bx-plus"></i> Nueva Asignación
        </button>
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="assignmentsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Empresa</th>
                    <th>Fecha de Asignación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->id }}</td>
                    <td>{{ $assignment->employee->name }}</td>
                    <td>{{ $assignment->company->name }}</td>
                    <td>{{ $assignment->assigned_at }}</td>
                    <td>
                        @if (!$assignment->removed_at)
                        <button class="btn btn-sm btn-light change-company-btn" data-bs-placement="top"
                            data-bs-toggle="tooltip" title="Cambiar empresa" data-id="{{ $assignment->id }}"
                            data-employee-id="{{ $assignment->employee_id }}" data-bs-toggle="modal"
                            data-bs-target="#changeCompanyModal">
                            <i class="bx bx-transfer-alt text-info"></i>
                        </button>

                        <button class="btn btn-sm btn-light deactivate-btn" data-bs-placement="top"
                            data-bs-toggle="tooltip" title="Desactivar asignación" data-id="{{ $assignment->id }}">
                            <i class="bx bx-power-off text-danger"></i>
                        </button>
                        @else
                        <span class="btn btn-sm btn-light" data-bs-placement="top"
                        data-bs-toggle="tooltip" title="Esta asignación ya está inactiva">
                            <i class="bx bx-info-circle text-secondary"></i> Inactiva
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@include('assignments.modalCreate')
@include('assignments.modalCambioCompany')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#assignmentsTable').DataTable();



    // Seleccionar opciones de select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'Seleccione una opción',
        dropdownParent: $('#createAssignmentModal')
    });

    // Crear asignación en el modal
    $('#createAssignmentForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('assignments.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#createAssignmentModal').modal('hide');
                $('#createAssignmentForm')[0].reset();
                $('#employee_id, #company_id').val(null).trigger('change');

                Swal.fire({
                    icon: 'success',
                    title: '¡Asignación creada!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Recargar la tabla o la página si es necesario
                location.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = 'Error al guardar la asignación.';

                if (errors) {
                    errorMsg = Object.values(errors).map(err => err[0]).join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg
                });
            }
        });
    });

    // Cuando se hace clic en el botón de cambiar empresa
    $(".change-company-btn").on("click", function() {
        const employeeId = $(this).data("employee-id");
        $("#change_employee_id").val(employeeId);
        $("#changeCompanyModal").modal("show");
    });

    // Envío del formulario para cambiar empresa
    $("#changeCompanyForm").on("submit", function(e) {
        e.preventDefault();

        const formData = {
            employee_id: $("#change_employee_id").val(),
            company_id: $("#new_company_id").val(),
        };

        $.ajax({
            url: "/assignments/change-company",
            method: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                $("#changeCompanyModal").modal("hide");
                Swal.fire("¡Actualizado!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                $("#changeCompanyModal").modal("hide");
                let msg = "Ocurrió un error.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire("Error", msg, "error");
            }
        });
    });

    // Desactivar asignación

    $(document).on("click", ".deactivate-btn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta asignación se marcará como inactiva.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Sí, desactivar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/assignments/${id}/deactivate`,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        Swal.fire("Desactivado", response.message, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire("Error", "No se pudo desactivar la asignación.", "error");
                    }
                });
            }
        });
    });
});
</script>
@endpush