<div class="modal fade" id="modalNuevoRol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoRol">
                    <div class="mb-3">
                        <label for="nombreRol" class="form-label">Nombre del Rol</label>
                        <input type="text" id="nombreRol" class="form-control" placeholder="Ingrese el nombre del rol" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionRol" class="form-label">Descripción</label>
                        <textarea id="descripcionRol" class="form-control" rows="3" placeholder="Ingrese una descripción" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="formNuevoRol">Guardar</button>
            </div>
        </div>
    </div>
</div>
