<!-- Modal Create Wallet -->
<div class="modal fade" id="createCarteraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Cartera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="createCarteraForm">
                    @csrf
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Empleado</label>
                        <select id="employee_id" class="form-select select2" name="employee_id" required>
                            <option value="">Seleccione...</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="issue_date" class="form-label">Fecha de emisión</label>
                        <input type="date" id="issue_date" name="issue_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="concept" class="form-label">Concepto</label>
                        <input type="text" id="concept" name="concept" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Monto</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>

            </div>
        </div>
    </div>
</div>