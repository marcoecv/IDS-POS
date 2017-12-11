<?php 
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/movimientosdecaja');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/movimientosdecaja');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Balance General');
?>

<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Balance General</h3>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="mc_initdate" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="mc_initdate" id="mc_initdate" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="mc_initTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="mc_initTime" id="mc_initTime" size="16" type="text" value=""/>
                    </div>
                    <div class="col-md-1">
                        <label for="mc_enddate" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="mc_enddate" id="mc_enddate" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="mc_endTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="mc_endTime" id="mc_endTime" size="16" type="text" value="" />
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
                        <button id="mc_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('mc_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
                        <b>Apuestas:&nbsp;</b><span id="totalA"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Pago Apuestas:&nbsp;</b><span id="totalI"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Apuestas Borradas:&nbsp;</b><span id="totalJ"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Dep Cta Existente:&nbsp;</b><span id="totalD"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Ret Cta Existente:&nbsp;</b><span id="totalR"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Retiros:&nbsp;</b><span id="totalF"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Inc. Saldo:&nbsp;</b><span id="totalE"></span>
                    </div>
                    <div class="col-md-1 totales">
                        <b>Balance:&nbsp;</b><span id="total"></span>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="mc_tableHeaderDiv" class="col col-md-12">
                    <table id="mc_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdFecha">Fecha/Hora</th>
                            <th class="tdCaja"># Caja</th>
                            <th class="tdDoc"># Transaccion</th>
                            <th class="tdUsuario">Usuario / Cuenta</th>
                            <th class="tdDescription">Descripcion</th>
                            <th class="tdTicket">Tiquete</th>
                            <th class="tdMonto">Apertura</th>
                            <th class="tdMonto">Cierre</th>
                            <th class="tdMonto">Apuestas</th>
                            <th class="tdMonto">Pago Apuestas</th>
                            <th class="tdMonto">Borrado Apuesta</th>
                            <th class="tdMonto">Dep. Cta Existente</th>
                            <th class="tdMonto">Ret. Cta Existente</th>
                            <th class="tdMonto">Ret Caja</th>
                            <th class="tdMonto">Inc. Saldo</th>
                        </tr>
                    </table>
                </div>
                <div id="mc_tableDiv" class="col col-md-12">
                    <table id="mc_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdCaja"># Caja</th>
                                <th class="tdDoc"># Transaccion</th>
                                <th class="tdUsuario">Usuario / Cuenta</th>
                                <th class="tdDescription">Descripcion</th>
                                <th class="tdTicket">Tiquete</th>
                                <th class="tdMonto">Apertura</th>
                                <th class="tdMonto">Cierre</th>
                                <th class="tdMonto">Apuestas</th>
                                <th class="tdMonto">Pago Apuestas</th>
                                <th class="tdMonto">Borrado Apuesta</th>
                                <th class="tdMonto">Dep. Cta Existente</th>
                                <th class="tdMonto">Ret. Cta Existente</th>
                                <th class="tdMonto">Ret Caja</th>
                                <th class="tdMonto">Inc. Saldo</th>
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




