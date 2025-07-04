@extends('layouts.app')
@section('title','Compañias')
@section('page-title','Bienvenido')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Compañias</h5>
        @can('crear companías')
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
            <i class="bx bx-plus"></i> Nueva Compañia
        </button>
        @endcan
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="companiesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>NIT</th>
                    <th>Tipo</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td class="text-center">{{ $company->name }}</td>
                    <td class="text-center">{{ $company->nit }}</td>
                    <td class="text-center">{{ ucfirst($company->type) }}</td>
                    <td class="text-center">{{ $company->phone }}</td>
                    <td class="text-center">{{ $company->email }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($company->status) }}
                        </span>
                    </td>
                    <td>
                        @can('editar companías')
                        <button class="btn btn-sm btn-light editCompanyBtn" data-id="{{ $company->id }}"
                            data-bs-target="#editCompanyModal" data-bs-placement="top" data-bs-toggle="tooltip"
                            title="Editar">
                            <i class="bx bx-edit-alt text-warning"></i>
                        </button>
                        @endcan
                        <button class="btn btn-sm btn-light btn-delete" data-id="{{ $company->id }}"
                            data-bs-placement="top" data-bs-toggle="tooltip" title="Eliminar">
                            <i class="bx bx-trash-alt text-danger"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@include('companies.modalCreate')
@include('companies.modalEdit')

@endsection




@push('scripts')
<script>
// Datatables
$(document).ready(function() {
    // Datatables
    $('#companiesTable').DataTable({
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

    //Crear compañia en el modal
    $("#createCompanyForm").submit(function(event) {
        event.preventDefault();

        // Usa FormData para enviar los datos correctamente
        let formData = new FormData();
        formData.append('name', $("#nombreEmpresa").val());
        formData.append('nit', $("#nitEmpresa").val());
        formData.append('address', $("#direccionEmpresa").val());
        formData.append('phone', $("#telefonoEmpresa").val());
        formData.append('email', $("#emailEmpresa").val());
        formData.append('type', $("#tipoEmpresa").val());
        formData.append('status', $("#estadoEmpresa").val());
        formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/companies",
            type: "POST",
            data: formData, // Envía FormData directamente
            processData: false, // Importante!
            contentType: false, // Importante!
            success: function(response) {
                $("#createCompanyModal").modal("hide");
                Swal.fire({
                    title: "¡Empresa Creada!",
                    text: response.message ||
                        "La empresa ha sido creada exitosamente.",
                    icon: "success"
                }).then(() => location.reload());
            },
            error: function(xhr) {
                let errorMsg = 'Ocurrió un error al crear la empresa.';

                if (xhr.status === 422) {
                    errorMsg = xhr.responseJSON.errors ?
                        Object.values(xhr.responseJSON.errors).join('\n') :
                        'Errores de validación';
                }

                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    //Traer informacion de la empresa para editar en el modal
    // Abrir el modal de edición para empresas
    $(document).on('click', '.editCompanyBtn', function() {
        var companyId = $(this).data('id');

        $.ajax({
            url: "/companies/" + companyId,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response);

                // Llenar el formulario del modal con los datos recibidos
                $('#editCompanyId').val(response.id);
                $('#editNombreEmpresa').val(response.name);
                $('#editNitEmpresa').val(response.nit);
                $('#editDireccionEmpresa').val(response.address);
                $('#editTelefonoEmpresa').val(response.phone);
                $('#editCorreoEmpresa').val(response.email);
                $('#editTipoEmpresa').val(response.type);
                $('#editEstadoEmpresa').val(response.status); // 'active' o 'inactive'
           // 'interna' o 'externa'
                $('#editCompanyModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener los datos de la empresa:", error);
            }
        });
    });

    // Cuando se envíe el formulario de actualización
    // Actualizar empresa en el modal
    $("#editCompanyForm").on("submit", function(e) {
        e.preventDefault();

        let companyId = $("#editCompanyId").val();

        let formData = {
            name: $("#editNombreEmpresa").val(),
            nit: $("#editNitEmpresa").val(),
            address: $("#editDireccionEmpresa").val(),
            phone: $("#editTelefonoEmpresa").val(),
            email: $("#editCorreoEmpresa").val(),
            status: $("#editEstadoEmpresa").val(),
            type: $("#editTipoEmpresa").val()
        };

        $.ajax({
            url: "/companies/" + companyId,
            type: "PUT",
            data: JSON.stringify(formData),
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                $("#editCompanyModal").modal("hide");
                Swal.fire({
                    title: "¡Empresa actualizada!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Errores de validación
                    let errors = xhr.responseJSON.errors;
                    let messages = Object.values(errors).map(msgArr => msgArr.join(" "))
                        .join("\n");

                    Swal.fire({
                        title: "Error de validación",
                        text: messages,
                        icon: "warning",
                        confirmButtonText: "Cerrar"
                    });
                } else {
                    // Otro tipo de error
                    console.error("Error inesperado:", xhr);
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error al actualizar la empresa.",
                        icon: "error",
                        confirmButtonText: "Cerrar"
                    });
                }
            }
        });
    });

    // Eliminar empresa en el modal
    $(document).on('click', '.btn-delete', function() {
        let companyId = $(this).data('id'); // Obtener el ID desde el botón

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/companies/${companyId}`,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado',
                            response.message,
                            'success'
                        );
                        // Recargar DataTable o actualizar la vista
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error',
                            xhr.responseJSON.message ||
                            'Hubo un problema al eliminar la empresa.',
                            'error'
                        );
                    }
                });
            }
        });
    });




});
</script>



</script>
@endpush