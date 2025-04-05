<!-- Modal Edit Company -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Compañía</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCompanyForm">
                    @csrf
                    @method('PUT') <!-- Para actualizar el registro -->
                    <input type="hidden" id="editCompanyId" name="editCompanyId">
                    
                    <div class="mb-3">
                        <label for="editNombreEmpresa" class="form-label">Nombre de la Compañía</label>
                        <input type="text" class="form-control" id="editNombreEmpresa" name="nombreEmpresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNitEmpresa" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="editNitEmpresa" name="nitEmpresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDireccionEmpresa" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="editDireccionEmpresa" name="direccionEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="editTelefonoEmpresa" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="editTelefonoEmpresa" name="telefonoEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="editCorreoEmpresa" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="editCorreoEmpresa" name="correoEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="editEstadoEmpresa" class="form-label">Estado</label>
                        <select class="form-select" id="editEstadoEmpresa" name="estadoEmpresa" required>
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
