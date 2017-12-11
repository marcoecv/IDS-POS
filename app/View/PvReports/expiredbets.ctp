<?php 
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/expiredbets');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/expiredbets');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Apuestas Vencidas');
?>
<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Apuestas Vencidas</h3>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="eb_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="eb_dateIni" id="eb_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="eb_initTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="eb_initTime" id="eb_initTime" size="16" type="text" value=""/>
                    </div>
                    <div class="col-md-1">
                        <label for="eb_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="eb_dateEnd" id="eb_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="eb_endTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="eb_endTime" id="eb_endTime" size="16" type="text" value="" />
                    </div>
                    <div class="col-md-1">
                        <label># de Caja: </label>
                        <input type="text" id="eb_caja"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-1">
                        <label>Tipo Apuesta: </label>
                        <select id="eb_tipoCuenta" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="1" selected>Todas</option>
                            <option value="2">Pagadas</option>
                            <option value="3">Por Pagar</option>
                        </select>
                    </div>
                  
                    <div class="col-md-1">
                        <button id="eb_searchTrans" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="eb_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('eb_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
            <div class="box-body">
                <div id="eb_tableHeaderDiv" class="col col-md-12">
                    <table id="eb_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdFecha">Fecha/Hora</th>
                            <th class="tdTicket">#Tiquete</th>
                            <th class="tdJugador">Jugador</th>
                            <th class="tdDescription">Descripcion</th>
                            <th class="tdRiesgo">Riesgo</th>
                            <th class="tdPagado">Ganado</th>
                            <th class="tdTipo">Tipo</th>
                            <th class="tdEstado">Estado</th>
                            <th class="tdPagar">Por Pagar</th>
                            <th class="tdPagado">Pagado</th>
                            <th class="tdCaja">Caja</th>
                        </tr>
                    </table>
                </div>
                <div id="eb_tableDiv" class="col col-md-12">
                    <table id="eb_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdTicket">#Tiquete</th>
                                <th class="tdJugador">Jugador</th>
                                <th class="tdDescription">Descripcion</th>
                                <th class="tdRiesgo">Riesgo</th>
                                <th class="tdPagado">Ganado</th>
                                <th class="tdTipo">Tipo</th>
                                <th class="tdEstado">Estado</th>
                                <th class="tdPagar">Por Pagar</th>
                                <th class="tdPagado">Pagado</th>
                                <th class="tdCaja">Caja</th>
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