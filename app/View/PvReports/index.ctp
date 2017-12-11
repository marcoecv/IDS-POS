<?php $this->Html->script('admin/pvReports/pvReports', array('inline' => false)); ?>

<?php
$this->assign('title', 'Reportes');

?>
<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="col-md-12">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body" style="height: 545px">
                <?=$buttonsPermission?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</div>

<div class="account-modal">
    <div class="modal" id="reprintTicket">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" style="font-size: 28px;">REIMPRIMIR TICKET</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                        <input id="ticketId" type="number" class="form-control input-lg keyboard-num"
                               placeholder="Ingrese el Numero de Ticket">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left btndal" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info btndal" id="setReprint">Reimprimir
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>