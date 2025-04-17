<!-- Modal para Abonar -->
<div class="modal fade" id="abonarModal" tabindex="-1" aria-labelledby="abonarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formAbonarCartera">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="abonarModalLabel">Registrar Abono</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" name="wallet_id" id="wallet_id">

          <div class="mb-3">
            <label for="payment_date" class="form-label">Fecha de Abono</label>
            <input type="date" class="form-control" name="payment_date" id="payment_date" required>
          </div>

          <div class="mb-3">
            <label for="amount" class="form-label">Monto</label>
            <input type="number" class="form-control" name="amount" id="amount" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Descripción (opcional)</label>
            <textarea class="form-control" name="description" id="description" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Registrar Abono</button>
        </div>
      </div>
    </form>
  </div>
</div>
