<?php $this->Html->script('admin/cashier/cashier', array('inline' => false)); 
echo $this->Html->css('admin/cashier/index');

$this->assign('title', 'Caja');

?>
<div class="col col-md-offset-8 col-md-4">
    <h2 style="margin-top: 0px;" class="pull-right">
        <small>Disponible Caja</small>
        $<span id="cajaBal">0.00</span>

    </h2>
</div>
<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="col-md-5">
        <div class="box" style="height: 545px">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div id="ct_tableHeaderDiv">
                    <table id="ct_tableHeader" class="table table-bordered  table-striped table-hover">
                        <tr>
                            <th class="ct_tdDate">Fecha/Hora</th>
                            <th class="ct_tdTran">#Transaccion</th>
                            <th class="ct_tdDesc">Descripcion</th>
                            <th class="ct_tdCredit">Credito</th>
                            <th class="ct_tdDebit">Debito</th>
                        </tr>
                    </table>
                </div>
                <div id="ct_tableDiv">
                    <table id="ct_table" class="table table-bordered  table-striped table-hover">
                    <?php
                    foreach ($transactions as $transaction) {

                    if ($transaction['Description'] == 'Apertura de Caja' || $transaction['Description'] == 'Retiro a Caja' || $transaction['Description'] == 'Incremento de Saldo' || $transaction['Description'] == 'Cierre de Caja')
                    {

                    ?>
                        <tr>
                            <td class="ct_tdDate"><?php echo substr($transaction['TranDateTime'], 0, 19) ?></td>
                            <td class="ct_tdTran"><?php echo $transaction['DocNum'] ?></td>
                            <td class="ct_tdDesc"><?php echo $transaction['Description'] ?></td>
                            <?php
                            if ((int)$transaction['Amount'] > 0) {
                                ?>
                                <td class="ct_tdCredit"><?php echo number_format(abs($transaction['Amount']), 2, '.', '') ?></td>
                                <td class="ct_tdDebit">0</td>
                                <?php
                            } else {
                                ?>
                                <td class="ct_tdCredit">0</td>
                                <td class="ct_tdDebit"><?php echo number_format(abs($transaction['Amount']), 2, '.', '') ?></td>

                                <?php
                            }
                            }

                            }
                            ?>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 ">
                    <hr style="border-top: 8px solid #bcced2;">
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-7">
        <div class="box" style="height: 545px">
            <div class="box-header">

            </div>
            <div class="box-body">
                <a href="/PvReports">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-block btn-info btn-lg btndash">Reportes
                    </div>
                </a>
                <a href="/DashboardAdmin">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-block btn-info btn-lg btndash">Lobby</button>
                    </div>

                </a>
                <?=$buttonsPermission?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</div>

<div class="account-modal">
    <div class="modal" id="abrirCaja">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" style="font-size: 28px;">APERTURA DE CAJA</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                        <input id="openAmount" type="number" class="form-control input-lg keyboard-num"
                               placeholder="0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left btndal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info btndal" id="sendAbrirCaja">Depositar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>

<div class="account-modal">
    <div class="modal" id="confirmAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar datos</h4>
                </div>
                <div class="modal-body">
                    <h3>
                        <small>ID:</small>
                        <span id="playerId"></span>
                    </h3>
                    <h3>
                        <small>Name:</small>
                        <span id="playerName"></span>
                    </h3>
                    <h3>
                        <small>Name:</small>
                        <span id="playerBal"></span>
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btndal pull-left" data-dismiss="modal">Cerrar</button>
                    <a id="btnConfirm" href="/sportbook">
                        <button type="button" class="btn btn-info btndal">Depositar</button>
                    </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>

<div class="account-modal">
    <div class="modal" id="confirmAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar datos</h4>
                </div>
                <div class="modal-body">
                    <h3>
                        <small>ID:</small>
                        <span id="playerId"></span>
                    </h3>
                    <h3>
                        <small>Name:</small>
                        <span id="playerName"></span>
                    </h3>
                    <h3>
                        <small>Name:</small>
                        <span id="playerBal"></span>
                    </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a id="btnConfirm" href="/sportbook">
                        <button type="button" class="btn btn-success">Confirm</button>
                    </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>

