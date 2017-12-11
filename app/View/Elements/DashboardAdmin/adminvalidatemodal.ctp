<div class="account-modal">
    <div class="modal" id="adminValidate">
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
                    <h4 class="modal-title text-center" style="font-size: 28px;color: #0265CD;">VALIDAR ADMINISTRADOR</h4>
                    <div class="form-group has-feedback">
                        <input id="adminUser" type="text" class="form-control input-lg keyboard-normal"
                               placeholder="Usuario" required style="height: 60px;font-size: 25px;">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="adminPass" type="password" class="form-control input-lg keyboard-normal"
                               placeholder="Clave"
                               required style="height: 60px;font-size: 25px;">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left btndal" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btndal" id="validAdmin">Aceptar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
