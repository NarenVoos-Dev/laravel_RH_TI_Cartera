<!-- Modal Create Employee -->
<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createEmployeeForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombreEmpleado" name="nombreEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="document_identification" class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="documentoEmpleado" name="documentoEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salario</label>
                        <input type="number" class="form-control" id="salarioEmpleado" name="salarioEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="transport_aid" class="form-label">Auxilio de Transporte</label>
                        <input type="number" class="form-control" id="auxilioTransporte" name="auxilioTransporte">
                    </div>
                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Fecha de Contratación</label>
                        <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select" id="estadoEmpleado" name="estadoEmpleado" required>
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>