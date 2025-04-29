<!-- index.blade.php -->
@extends('layouts.app')
@section('title','Empleados')
@section('page-title','Bienvenido')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Empleados</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
            <i class="bx bx-plus"></i> Nuevo Empleado
        </button>
    </div>
</div>
<div class="p-4 mt-4 card">
    <div class="table-responsive text-nowrap">
        <table id="employeesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre Completo</th>
                    <th>Documento</th>
                    <th>Salario</th>
                    <th>Auxilio de Transporte</th>
                    <th>Fecha de Contratación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td class="text-center">{{ $employee->name }}</td>
                    <td class="text-center">{{ $employee->document_identification }}</td>
                    <td class="text-center">${{ number_format($employee->salary, 2) }}</td>
                    <td class="text-center">${{ number_format($employee->transport_aid, 2) }}</td>
                    <td class="text-center">{{ $employee->hire_date }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $employee->status == 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-light editEmployeeBtn" data-id="{{ $employee->id }}"
                            data-bs-target="#editEmployeeModal" data-bs-placement="top" data-bs-toggle="tooltip"
                            title="Editar">
                            <i class="bx bx-edit-alt text-warning"></i>
                        </button>
                        <button class="btn btn-sm btn-light" onclick="deactivateEmployee({{ $employee->id }})"
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

@include('employees.modal-create')
@include('employees.modal-edit')

@endsection


@push('scripts')
<script>
// Datatables
    $(document).ready(function() {
// Datatables
        $('#employeesTable').DataTable({
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
       

    });

//Crear empleado en el modal
    document.getElementById("createEmployeeForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita la recarga de la página

        let nombreEmpleado = document.getElementById("nombreEmpleado").value;
        let documentoEmpleado = document.getElementById("documentoEmpleado").value;
        let salarioEmpleado = document.getElementById("salarioEmpleado").value;
        let auxilioTransporte = document.getElementById("auxilioTransporte").value;
        let fechaIngreso = document.getElementById("fechaIngreso").value;
        let estadoEmpleado = document.getElementById("estadoEmpleado").value;


        fetch('/employees', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: nombreEmpleado,
                    document_identification: documentoEmpleado,
                    salary: salarioEmpleado,
                    transport_aid: auxilioTransporte,
                    hire_date: fechaIngreso,
                    status: estadoEmpleado
                })
            })
            .then(response => response.json())
            .then(data => {
                $('#createEmployeeModal').modal('hide'); // Ocultar el modal
                Swal.fire({
                    title: "¡Empleado Creado!",
                    text: "El empleado ha sido creado exitosamente.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload(); // Recargar la tabla para ver el nuevo empleado
                });
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al crear el empleado.",
                    icon: "error",
                    confirmButtonText: "Cerrar"
                });
            });
    });


//Abrir el modal de edición
    $(document).on('click', '.editEmployeeBtn', function() {
        var employeeId = $(this).data('id');


        $.ajax({
            url: "/employees/" + employeeId,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log("Datos recibidos:", response); // Verifica los datos en la consola

                // Llenar el formulario con los datos del empleado
                $('#editEmployeeId').val(response.id);
                $('#editNombreEmpleado').val(response.name);
                $('#editDocumentoEmpleado').val(response.document_identification);
                $('#editSalarioEmpleado').val(response.salary);
                $('#editAuxilioTransporte').val(response.transport_aid);
                $('#editFechaIngreso').val(response.hire_date);
                $('#editEstadoEmpleado').val(response.status);
                $('#editEmployeeModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error en AJAX:", error);
            }
        });
    });

    // Cuando se envíe el formulario de actualización
// Actualizar empleado en el modal
    document.getElementById("editEmployeeForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita la recarga de la página

        let employeeId = document.getElementById("editEmployeeId").value; // Obtener el ID del empleado
        let nombreEmpleado = document.getElementById("editNombreEmpleado").value;
        let documentoEmpleado = document.getElementById("editDocumentoEmpleado").value;
        let salarioEmpleado = document.getElementById("editSalarioEmpleado").value;
        let auxilioTransporte = document.getElementById("editAuxilioTransporte").value;
        let fechaIngreso = document.getElementById("editFechaIngreso").value;
        let estadoEmpleado = document.getElementById("editEstadoEmpleado").value;

        fetch('/employees/' + employeeId, {
                method: 'PUT', // Método PUT para actualizar
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: nombreEmpleado,
                    document_identification: documentoEmpleado,
                    salary: salarioEmpleado,
                    transport_aid: auxilioTransporte,
                    hire_date: fechaIngreso,
                    status: estadoEmpleado
                })
            })
            .then(response => response.json())
            .then(data => {
                $('#editEmployeeModal').modal('hide'); // Ocultar el modal
                Swal.fire({
                    title: "¡Empleado Actualizado!",
                    text: "El empleado ha sido actualizado exitosamente.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload(); // Recargar la tabla para ver el empleado actualizado
                });
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al actualizar el empleado.",
                    icon: "error",
                    confirmButtonText: "Cerrar"
                });
            });
    });

//desactivar empleado y no eliminar
    function deactivateEmployee(employeeId) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "El empleado será inactivado, pero no eliminado.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, inactivar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/employees/${employeeId}/inactivate`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire("Empleado inactivado", data.message, "success");
                        location.reload(); // Recargar la tabla
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire("Error", "Hubo un problema al inactivar el empleado.", "error");
                    });
            }
        });
    }
</script>



</script>
@endpush