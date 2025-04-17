<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial de abonos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <h6>Empleado: <span id="nombreEmpleado"></span></h6>
                <h6>Saldo inicial: <span id="saldoInicial"></span> COP</h6>
                <h6>Saldo actual: <span id="saldoActual"></span> COP</h6>

                <table class="table mt-3 table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha de Abono</th>
                            <th>Monto</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="historialBody">
                        <!-- Aquí se insertan los movimientos con JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
