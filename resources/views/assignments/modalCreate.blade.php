<!-- Modal Create Assignment -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Asignación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="createAssignmentForm" action="{{ route('assignments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Empleado</label>
                        <select class="form-select select2" id="employee_id" name="employee_id" required>
                            <option value="" disabled selected>Selecciona un empleado</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->document_identification }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="company_id" class="form-label">Empresa</label>
                        <select class="form-select select2" id="company_id" name="company_id" required>
                            <option value="" disabled selected>Selecciona una empresa</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->nit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar Asignación</button>
                </form>
            </div>
        </div>
    </div>
</div>

