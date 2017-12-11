<?php 
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/balancecaja');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/balancecaja');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Balance de Cajas');
?>

<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Balance de Cajas</h3>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="bc_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="bc_dateIni" id="bc_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="bc_initTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="bc_initTime" id="bc_initTime" size="16" type="text" value=""/>
                    </div>
                    <div class="col-md-1">
                        <label for="bc_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="bc_dateEnd" id="bc_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="bc_endTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="bc_endTime" id="bc_endTime" size="16" type="text" value="" />
                    </div>
                    <div class="col-md-1">
                        <label># de Caja: </label>
                        <input type="text" id="mc_caja"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-1">
                        <button id="mc_searchTrans" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i
                                class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="mc_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('bc_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
                    </div>
                    <div class="col-md-3">
                        <button class=" btn btn-success" style="width: 50%;height: 48px;font-size: 26px;" onclick="window.location.replace('/DashboardAdmin')">LOBBY</button>
                        <button class=" btn btn-success" style="width: 49%;height: 48px;font-size: 26px;" onclick="window.location.replace('/PvReports')">REPORTES</button>
                    </div>

                </div>
                <div class="row">
                    <hr style="margin: 0px 7px 0px 7px; border-color: #0c0c0c">
                </div>
            </div>
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1 totales">
                        <b>Cr&eacute;ditos:&nbsp;</b><span id="totalCred"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>D&eacute;bitos:&nbsp;</b><span id="totalDeb"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Balance Total:&nbsp;</b><span id="totalBal"></span>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="bc_tableHeaderDiv" class="col col-md-12">
                    <table id="bc_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdFecha">Fecha/Hora</th>
                            <th class="tdCaja"># Caja</th>
                            <th class="tdTransaccion"># Transacci&oacute;n</th>
                            <th class="tdUsuario">Usuario / Cuenta</th>
                            <th class="tdDescription">Descripcion</th>
                            <th class="tdTicket">Ticket</th>
                            <th class="tdCdredito">Cr&eacute;ditos</th>
                            <th class="tdDebito">D&eacute;bitos</th>
                            <th class="tdBalance">Balance</th>
                        </tr>
                    </table>
                </div>
                <div id="bc_tableDiv" class="col col-md-12">
                    <table id="bc_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdCaja"># Caja</th>
                                <th class="tdTransaccion"># Transacci&oacute;n</th>
                                <th class="tdUsuario">Usuario / Cuenta</th>
                                <th class="tdDescription">Descripcion</th>
                                <th class="tdTicket">Ticket</th>
                                <th class="tdCdredito">Cr&eacute;ditos</th>
                                <th class="tdDebito">D&eacute;bitos</th>
                                <th class="tdBalance">Balance</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




