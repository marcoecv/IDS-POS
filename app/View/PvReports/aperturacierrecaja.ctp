<?php 
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/aperturacierrecaja');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/aperturacierrecaja');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Aperturas y Cierres');
?>

<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Aperturas y Cierres</h3>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="ac_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="ac_dateIni" id="ac_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="ac_initTime" class="control-label editGameLabelWith">Hora: </label>
                        <input class="form-control" name="ac_initTime" id="ac_initTime" size="16" type="text" value="" required>
                    </div>
                    <div class="col-md-1">
                        <label for="ac_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="ac_dateEnd" id="ac_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="ac_endTime" class="control-label editGameLabelWith">Hora: </label>
                        <input class="form-control" name="ac_endTime" id="ac_endTime" size="16" type="text" value="" required>
                    </div>
                    <div class="col-md-1">
                        <label># de Caja: </label>
                        <input type="text" id="ac_caja"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-1">
                        <button id="ac_searchTrans" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i
                                class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="ac_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel()" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
                <div id="ac_tableHeaderDiv" class="col col-md-12">
                    <table id="ac_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdCaja"># Caja</th>
                            <th class="tdFecha">Fecha/Hora Apertura</th>
                            <th class="tdFecha">Fecha/Hora Cierre</th>
                            <th class="tdTransaccion"># Transacci&oacute;n Apertura</th>
                            <th class="tdTransaccion"># Transacci&oacute;n Cierre</th>
                            <th class="tdCredito">Cr&eacute;ditos</th>
                            <th class="tdDebito">D&eacute;bitos</th>
                            <th class="tdBalance">Balance</th>
                        </tr>
                    </table>
                </div>
                <div id="ac_tableDiv" class="col col-md-12">
                    <table id="ac_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdCaja"># Caja</th>
                                <th class="tdFecha">Fecha/Hora Apertura</th>
                                <th class="tdFecha">Fecha/Hora Cierre</th>
                                <th class="tdTransaccion"># Transacci&oacute;n Apertura</th>
                                <th class="tdTransaccion"># Transacci&oacute;n Cierre</th>
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




