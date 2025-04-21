<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="rolUsuario" class="form-label">Rol</label>
                        <select class="form-select" id="rolUsuario" name="rolUsuario" required>
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="companiaUsuario" class="form-label">Compañia</label>
                        <select class="form-select" id="companiaUsuario" name="companiaUsuario" >
                            <option value="">Seleccione una compañia</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estadoUsuario" class="form-label">Estado</label>
                        <select class="form-select" id="estadoUsuario" name="estadoUsuario" required>
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