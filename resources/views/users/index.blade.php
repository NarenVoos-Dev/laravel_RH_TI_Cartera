<!-- index.blade.php -->
@extends('layouts.app')
@section('title','Usuarios')
@section('page-title','Bienvenido')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Usuarios</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bx bx-plus"></i> Nuevo Usuario
        </button>
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="usersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->username }}</td>
                    <td class="text-center">{{ $user->role->name ?? 'Sin Rol' }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-light editUserBtn" data-id="{{ $user->id }}"
                            data-bs-target="#editUserModal" data-bs-placement="top" data-bs-toggle="tooltip"
                            title="Editar">
                            <i class="bx bx-edit-alt text-warning"></i>
                        </button>
                        <button class="btn btn-sm btn-light" onclick="deactivateUser({{ $user->id }})"
                            data-bs-placement="top" data-bs-toggle="tooltip" title="Inactivar">
                            <i class="bx bx-trash-alt text-danger"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@include('users.modal-Create')
@include('users.modal-Edit')

@endsection


@push('scripts')
<script>
// Datatables
$(document).ready(function() {
    // Datatables
    $('#usersTable').DataTable({
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

//Crear usuario en el modal
document.getElementById("createUserForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita la recarga de la página

    let nombreUsuario = document.getElementById("nombreUsuario").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let rolUsuario = document.getElementById("rolUsuario").value;
    let estadoUsuario = document.getElementById("estadoUsuario").value;

    console.log(nombreUsuario, username, password, rolUsuario, estadoUsuario);
    fetch('/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            name: nombreUsuario,
            username: username,
            password: password,
            role_id: rolUsuario,
            status: estadoUsuario
        })
    })
    .then(response => response.json())
    .then(data => {
        $('#createUserModal').modal('hide'); // Ocultar el modal
        Swal.fire({
            title: "¡Usuario Creado!",
            text: "El usuario ha sido creado exitosamente.",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            location.reload(); // Recargar la tabla para ver el nuevo usuario
        });
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al crear el usuario.",
            icon: "error",
            confirmButtonText: "Cerrar"
        });
    });
});



//Abrir el modal de edición de usuario
$(document).on('click', '.editUserBtn', function() {
    
    var userId = $(this).data('id');
    $('#editUserModal').modal('show'); // Ocultar el modal

    $.ajax({
        url: "/users/" + userId,
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Llenar el formulario con los datos del usuario
            $('#editUserId').val(response.id);
            $('#editUserName').val(response.name);
            $('#editUsername').val(response.username);
            $('#editPassword').val(''); // Dejamos la contraseña vacía para que no se muestre
            $('#editRole').val(response.role_id);
            $('#editStatus').val(response.status);
            $('#editUserModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Error en AJAX:", error);
        }
    });
});


// Cuando se envíe el formulario de actualización
// Actualizar empleado en el modal
document.getElementById("editUserForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita la recarga de la página

    let userId = document.getElementById("editUserId").value; // Obtener el ID del usuario
    let userName = document.getElementById("editUserName").value;
    let username = document.getElementById("editUsername").value;
    let password = document.getElementById("editPassword").value; // La contraseña se enviará vacía si no se cambia
    let role = document.getElementById("editRole").value;
    let status = document.getElementById("editStatus").value;

    // Si la contraseña está vacía, no la enviamos
    let bodyData = {
        name: userName,
        username: username,
        role_id: role,
        status: status
    };

    // Solo añadimos la contraseña si fue cambiada
    if (password) {
        bodyData.password = password;
    }

    console.log(bodyData);

    fetch('/users/' + userId, {
        method: 'PUT', // Método PUT para actualizar
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(bodyData)
    })
    .then(response => response.json())
    .then(data => {
        $('#editUserModal').modal('hide'); // Ocultar el modal
        Swal.fire({
            title: "¡Usuario Actualizado!",
            text: "El usuario ha sido actualizado exitosamente.",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            location.reload(); // Recargar la tabla para ver el usuario actualizado
        });
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el usuario.",
            icon: "error",
            confirmButtonText: "Cerrar"
        });
    });
});


//desactivar empleado y no eliminar
function deactivateUser(userId) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "El usuario será inactivado, pero no eliminado.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, inactivar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/users/${userId}/inactivate`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire("Usuario inactivado", data.message, "success");
                    location.reload(); // Recargar la tabla de usuarios
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("Error", "Hubo un problema al inactivar el usuario.", "error");
                });
        }
    });
}

</script>



</script>
@endpush