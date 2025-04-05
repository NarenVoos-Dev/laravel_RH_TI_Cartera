<!-- Modal Create Company -->
<div class="modal fade" id="createCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCompanyForm">
                    @csrf
                    <div class="mb-3">
                        <label for="nombreEmpresa" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreEmpresa" name="nombreEmpresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="nitEmpresa" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nitEmpresa" name="nitEmpresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionEmpresa" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionEmpresa" name="direccionEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="telefonoEmpresa" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoEmpresa" name="telefonoEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="emailEmpresa" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="emailEmpresa" name="emailEmpresa">
                    </div>
                    <div class="mb-3">
                        <label for="estadoEmpresa" class="form-label">Estado</label>
                        <select class="form-select" id="estadoEmpresa" name="estadoEmpresa" required>
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
