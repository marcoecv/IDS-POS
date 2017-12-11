<div class="account-modal">
        <div class="modal" id="newAccount">
            <div class="modal-dialog" style="width: 75%;">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 10px 10px 0px 0px;height: 48px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"
                                style="color: #FF3334;font-size: 24px;opacity: 1;">
                                <i class="fa fa-times-circle"
                                style="font-size: 40px;"></i></button>

                    </div>
                    <div class="modal-body" style="padding: 0px 15px 0px 15px;">

                        <h4 class="modal-title text-center" style="font-size: 28px;color: #0265CD;">CUENTA NUEVA</h4>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input id="newNombre" type="text" class="form-control input-lg keyboard-normal"
                                       placeholder="Nombre"
                                       required style="height: 60px;font-size: 25px;">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input id="newEmail" type="email" class="form-control input-lg keyboard-normal"
                                       placeholder="Email"
                                       required style="height: 60px;font-size: 25px;">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input id="newDireccion" type="text" class="form-control input-lg keyboard-normal"
                                       placeholder="Direccion"
                                       required style="height: 60px;font-size: 25px;">
                                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input id="newTelefono" type="phone" class="form-control input-lg keyboard-num"
                                       placeholder="Telefono"
                                       required style="height: 60px;font-size: 25px;">
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input id="newClave" type="password" class="form-control input-lg keyboard-normal"
                                       placeholder="Clave"
                                       required style="height: 60px;font-size: 25px;">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <button type="button" class="btn btn-block btn-success btn-lg "
                                        onclick="SignupFormSubmit()" style="height:60px; font-size:27px;  "><i
                                        class="fa fa-check-circle" style="font-size: 30px;"></i>Crear
                                    Cuenta Nueva
                                </button>

                            </div>
                        </div>
                        <a href="#">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-danger btn-lg "
                                        data-dismiss="modal" style="height:60px; font-size:27px;">Cancelar
                                </button>
                            </div>
                        </a>

                        <div class="row">
                            <div class="col-xs-5">

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">

                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="modal-footer" style="padding-left: 2px;">
                            <a href="/DashboardAdmin">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-block btn-info btn-lg btndal" style="margin-left: 5px;">Lobby</button>
                                </div>
                            </a>
                            <a href="/cashier/cajero">
                                <div class="col-md-6 ">
                                    <button type="button" class="btn btn-block btn-info btn-lg btndal">Caja</button>
                                </div>
                            </a>

                        </div>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
