<!-- Modal -->
<div class="modal fade" id="modalAgregarConcepto" tabindex="-1" aria-labelledby="modalAgregarConceptoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('payroll_detail_items.store', $detail->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Agregar concepto manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <option value="earning">Devengado</option>
                        <option value="deduction">Deducción</option>
                    </select>
                </div>

                <div class="col-md-8">
                    <label for="concept_id" class="form-label">Concepto (existente o nuevo)</label>
                    <input type="text" class="form-control" name="concept_name" id="concept_name"
                        placeholder="Escriba o seleccione un concepto" required list="conceptos-list">
                    <datalist id="conceptos-list">
                        {{-- Devengados --}}
                        @foreach(\App\Models\Earning::all() as $e)
                        <option value="{{ $e->name }}">
                            @endforeach
                            {{-- Deducciones --}}
                            @foreach(\App\Models\Deduction::all() as $d)
                        <option value="{{ $d->name }}">
                            @endforeach
                    </datalist>
                </div>

                <div class="col-md-4">
                    <label for="amount" class="form-label">Valor</label>
                    <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>

    </div>
</div>