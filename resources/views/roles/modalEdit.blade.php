<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editRoleId">
                <div class="mb-3">
                    <label for="editRoleName" class="form-label">Nombre del Rol</label>
                    <input type="text" id="editRoleName" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="editRoleDescription" class="form-label">Descripción</label>
                    <textarea id="editRoleDescription" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="updateRole()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
