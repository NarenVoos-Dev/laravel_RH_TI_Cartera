@extends('layouts.app')

@section('title','Roles')

@section('page-title','Bienvenido')

@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listado de Roles</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoRol">
            <i class="bx bx-plus"></i> Nuevo Rol
        </button>
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="rolesTable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                        <button class="btn btn-sm btn-light" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"    
                        onclick="window.openEditModal({{ $role->id }}, '{{ $role->name }}', '{{ $role->description }}')">
                            <i class="bx bx-edit-alt text-warning"></i>
                        </button>
                        <button class="btn btn-sm btn-light" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"
                        onclick="deleteRole({{ $role->id }})">
                            <i class="bx bx-trash-alt text-danger"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!--/ Basic Bootstrap Table -->
@include('roles.modalCreate')
@include('roles.modalEdit')

@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        // Datatables
        $('#rolesTable').DataTable({
            "order": [[ 0, "desc" ]], // Ordena por la primera columna en orden descendente
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
    //Crear rol en el modal
    document.getElementById("formNuevoRol").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita que la página se recargue

        let nombreRol = document.getElementById("nombreRol").value;
        let descripcionRol = document.getElementById("descripcionRol").value;

        fetch('/roles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name: nombreRol, description: descripcionRol })
        })
        .then(response => response.json())
        .then(data => {
            $('#modalNuevoRol').modal('hide'); // Ocultar el modal
            Swal.fire({
                title: "¡Rol Creado!",
                text: "El rol ha sido creado exitosamente.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                location.reload(); // Recargar la tabla para ver el nuevo rol
            });
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                title: "Error",
                text: "Hubo un problema al crear el rol.",
                icon: "error",
                confirmButtonText: "Cerrar"
            });
        });
    });

    // abrir el modal de edición
    window.openEditModal = function(id, name, description) {
        $('#editRoleId').val(id);
        $('#editRoleName').val(name);
        $('#editRoleDescription').val(description);
        $('#editRoleModal').modal('show');
    };
    //guardar cambios
    function updateRole() {
        let id = $('#editRoleId').val();
        let name = $('#editRoleName').val();
        let description = $('#editRoleDescription').val();

        $.ajax({
            url: '/roles/' + id,
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: name,
                description: description
            },
            success: function(response) {
                $('#editRoleModal').modal('hide');
                Swal.fire('Actualizado', 'El rol ha sido actualizado correctamente', 'success')
                    .then(() => location.reload());
            },
            error: function(xhr) {
                Swal.fire('Error', 'No se pudo actualizar el rol', 'error');
            }
        });
    }

    //Eliminar rol
    function deleteRole(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/roles/' + id,  // Asegúrate de que esta ruta exista en web.php
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Eliminado', 'El rol ha sido eliminado.', 'success')
                            .then(() => location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo eliminar el rol.', 'error');
                    }
                });
            }
        });
    }


</script>
@endpush