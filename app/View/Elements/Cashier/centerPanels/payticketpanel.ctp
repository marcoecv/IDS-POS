<div id="cajero_payTicketPanel" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 hideShow" style="display: none">
    <div>
        <div id="ticket-resumeHeader">
            <table id="pt_resumenHeaderTable" class="table table-bordered  table-striped table-hover">
                <tr>
                    <th class="tdBorrar">Borrar</th>
                    <th class="tdTiquete"># Tiquete</th>
                    <th class="tdGanado">Ganado</th>
                    <th class="tdRetention">Retencion</th>
                    <th class="tdSubTotal">Sub-Total</th>
                </tr>
            </table>
        </div>
        <!-- /.box-header -->
        <div id="ticket-resume" class="box-body" style="height: 350px; overflow-y: scroll;padding: 0px 0px 0px 0px !important;width: 104%">
            <table id="pt_resumenTable" class="table table-bordered  table-striped table-hover">
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix no-border">

        </div>
    </div>
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-12">
            <div class="col-md-6" style="padding: 0 2px;">
                <button type="button" class="btn btn-default btntac" style="width: 100%; color: black;font-size: 25px" disabled="">
                    <span style="">Total a Pagar</span>
                </button>
            </div>
            <div class="col-md-6" style="padding: 0 2px;">
                <button type="button" class="btn btn-default btntac" style="width: 100%; color: black;font-size: 25px"  disabled="">
                    <span class="pull-right">$
                        <span id="pay-total">0.00</span></span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="padding: 0 10px 0 10px">
            <a href="/cashier/deposit" style="color:#fff;">
                <button type="button" class="btn btn-success pull-right btntac" id="pagarTickets"
                        style="width: 100%;font-size: 45px;">
                    PAGAR
            </a>
        </div>

    </div>
</div>
