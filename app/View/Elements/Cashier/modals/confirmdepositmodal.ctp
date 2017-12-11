<div class="account-modal">
    <div class="modal" id="confirmDeposit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-size: 28px;">Confirmar Deposito</h4>
                </div>
                <div class="modal-body">

                    <h3>
                        <small>Nombre:</small>
                        <span id="depositname"></span>
                    </h3>
                    <h3>
                        <small>Descripcion:</small>
                        <span>Deposit</span>
                    </h3>
                    <h2>
                        <small>Monto:</small>
                        $<span id="depMonto">0</span>
                    </h2>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info pull-left btndal" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btndal" onclick="depositarCuenta()">Depositar
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>