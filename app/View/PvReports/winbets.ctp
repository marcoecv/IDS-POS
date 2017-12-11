<?php 
    echo $this->Html->script('angular.min');
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/winbets');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/winbets');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Apuestas Ganadas');
?>
<div ng-app="app" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Apuestas Ganadas</h3>
    <div ng-controller="wonBetsController" class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="wb_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="wb_dateIni" id="wb_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="wb_initTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="wb_initTime" id="wb_initTime" size="16" type="text" value="00:00"/>
                    </div>
                    <div class="col-md-1">
                        <label for="wb_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="wb_dateEnd" id="wb_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="wb_endTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="wb_endTime" id="wb_endTime" size="16" type="text" value="23:59" />
                    </div>
                    <div class="col-md-1">
                        <label># de Caja: </label>
                        <input type="text" id="wb_caja"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-1">
                        <label>Tipo Apuesta: </label>
                        <select id="wb_tipoCuenta" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="1" selected>Todas</option>
                            <option value="2">Pagadas</option>
                            <option value="3">Por Pagar</option>
                        </select>
                    </div>
                  
                    <div class="col-md-1">
                        <button id="wb_searchTrans" ng-click="getData()" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="wb_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('wb_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
                <div id="wb_tableHeaderDiv" class="col col-md-12">
                    <table id="wb_headerTable" class="table table-bordered  table-striped table-hover" style="">
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
                <div id="wb_tableDiv" class="col col-md-12">
                    <table id="wb_table" class="table table-bordered  table-striped table-hover" style="">
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
                        <tbody>
                            <tr ng-repeat="bets in wonBets">
                                <td class="tdFecha">{{bets.TranDateTime}}</td>
                                <td class="tdTicket">{{bets.TicketNumber}}</td>
                                <td class="tdJugador">{{bets.UserAccount}}</td>
                                <td class="tdDescription">{{bets.Description}}</td>
                                <td class="tdRiesgo">{{bets.Risk}}</td>
                                <td class="tdPagado">{{bets.Won}}</td>
                                <td class="tdTipo">{{bets.WagerType}}</td>
                                <td class="tdEstado">{{bets.WagerStatus}}</td>
                                <td class="tdPagar"><i class="{{bets.toPayIcon}}"></i></td>
                                <td class="tdPagado"><i class="{{bets.paidIcon}}"></i></td>
                                <td class="tdCaja">{{bets.BoxID}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="tdFecha"></td>
                                <td class="tdTicket">Cantidad:&nbsp;{{cantidad}}</td>
                                <td class="tdJugador"></td>
                                <td class="tdDescription"></td>
                                <td class="tdRiesgo">{{riesgoTotal}}</td>
                                <td class="tdPagado">{{ganadoTotal}}</td>
                                <td class="tdTipo"></td>
                                <td class="tdEstado"></td>
                                <td class="tdPagar">{{totalPagado}}</td>
                                <td class="tdPagado">{{totalPorPagar}}</td>
                                <td class="tdCaja"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>