<div class="modal fade" id="changeCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="changeCompanyForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="employee_id" id="change_employee_id">
                    <div class="mb-3">
                        <label for="new_company_id" class="form-label">Nueva Empresa</label>
                        <select name="company_id" id="new_company_id" class="form-select" required>
                            <option value="">Seleccione una empresa</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambio</button>
                </div>
            </div>
        </form>
    </div>
</div>