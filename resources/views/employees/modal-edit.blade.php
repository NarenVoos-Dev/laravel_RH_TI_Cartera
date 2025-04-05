<!-- Modal Edit Employee -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm">
                    @csrf
                    @method('PUT') <!-- Para actualizar el registro -->
                    <input type="hidden" id="editEmployeeId" name="id">
                    
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="editNombreEmpleado" name="nombreEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDocumentIdentification" class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="editDocumentoEmpleado" name="documentoEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSalary" class="form-label">Salario</label>
                        <input type="number" class="form-control" id="editSalarioEmpleado" name="salarioEmpleado" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTransportAid" class="form-label">Auxilio de Transporte</label>
                        <input type="number" class="form-control" id="editAuxilioTransporte" name="auxilioTransporte">
                    </div>
                    <div class="mb-3">
                        <label for="editHireDate" class="form-label">Fecha de Contratación</label>
                        <input type="date" class="form-control" id="editFechaIngreso" name="fechaIngreso" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Estado</label>
                        <select class="form-select" id="editEstadoEmpleado" name="estadoEmpleado" required>
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
