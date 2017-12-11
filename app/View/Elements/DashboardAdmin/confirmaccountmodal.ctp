<div class="account-modal">
        <div class="modal" id="confirmAccount">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 10px 10px 0px 0px;height: 68px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"
                                style="color: #FF3334;font-size: 24px;opacity: 1;">
                            <span style="vertical-align: super; font-size: 24px;">Cerrar</span><i
                                class="fa fa-times-circle"
                                style="font-size: 60px;"></i></button>

                    </div>
                    <div class="modal-body" style="padding: 0px 15px 0px 15px;">
                        <h3>
                            <small>ID:</small>
                            <span id="playerId"></span>
                        </h3>
                        <h3>
                            <small>Nombre:</small>
                            <span id="playerName"></span>
                        </h3>
                        <h3>
                            <small>Disponible:</small>
                            <span id="playerBal"></span>
                        </h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left btndal" data-dismiss="modal">Cerrar
                        </button>
                        <a id="btnConfirm" href="/sportbook">
                            <button type="button" class="btn btn-success btndal">Confirmar</button>
                        </a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
