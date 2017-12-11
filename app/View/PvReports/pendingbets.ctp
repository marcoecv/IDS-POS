<?php 
    echo $this->Html->script('angular.min');
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/pendingbets');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/pendingbets');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Apuestas Pendientes');
?>
<div ng-app="app" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Apuestas Pendientes</h3>
    <div ng-controller="pendingBetsController" class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-2">
                        <label># de Caja: </label>
                        <input type="text" id="pb_caja"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-2">
                        <label>Tipo Cuenta: </label>
                        <select id="pb_tipoCuenta" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="1">Anonima</option>
                            <option value="2">Existente</option>
                            <option value="3">Todas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="pb_searchTrans" ng-click="getData()" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button id="pb_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('pb_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
                    </div>
                    <div class="col-md-4">
                        <button class=" btn btn-success" style="width: 50%;height: 48px;font-size: 26px;" onclick="window.location.replace('/DashboardAdmin')">LOBBY</button>
                        <button class=" btn btn-success" style="width: 49%;height: 48px;font-size: 26px;" onclick="window.location.replace('/PvReports')">REPORTES</button>
                    </div>

                </div>
                <div class="row">
                    <hr style="margin: 0px 7px 0px 7px; border-color: #0c0c0c">
                </div>
            </div>
            <div class="box-body">
                <div id="pb_tableHeaderDiv" class="col col-md-12">
                    <table id="pb_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdFecha">Fecha/Hora</th>
                            <th class="tdTicket">#Tiquete</th>
                            <th class="tdJugador">Jugador</th>
                            <th class="tdDescription">Descripcion</th>
                            <th class="tdRiesgo">Riesgo</th>
                            <th class="tdGanar">Por Ganar</th>
                            <th class="tdTipo">Tipo</th>
                            <th class="tdEstado">Estado</th>
                            <th class="tdCaja">Caja</th>
                        </tr>
                    </table>
                </div>
                <div id="pb_tableDiv" class="col col-md-12">
                    <table id="pb_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdTicket">#Tiquete</th>
                                <th class="tdJugador">Jugador</th>
                                <th class="tdDescription">Descripcion</th>
                                <th class="tdRiesgo">Riesgo</th>
                                <th class="tdGanar">Por Ganar</th>
                                <th class="tdTipo">Tipo</th>
                                <th class="tdEstado">Estado</th>
                                <th class="tdCaja">Caja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="bet in pendingBets">
                                <td class="tdFecha">{{bet.TranDateTime}}</td>
                                <td class="tdTicket">{{bet.TicketNumber}}</td>
                                <td class="tdJugador">{{bet.UserAccount}}</td>
                                <td class="tdDescription">{{bet.Description}}</td>
                                <td class="tdRiesgo">{{bet.Risk}}</td>
                                <td class="tdGanar">{{bet.ToWinAmount}}</td>
                                <td class="tdTipo">{{bet.WagerType}}</td>
                                <td class="tdEstado">{{bet.WagerStatus}}</td>
                                <td class="tdCaja">{{bet.BoxID}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="tdFecha"></td>
                                <td class="tdTicket">Cantidad:&nbsp;{{cantidad}}</td>
                                <td class="tdJugador"></td>
                                <td class="tdDescription"></td>
                                <td class="tdRiesgo">{{riesgoTotal}}</td>
                                <td class="tdGanar">{{totalToWin}}</td>
                                <td class="tdTipo"></td>
                                <td class="tdEstado"></td>
                                <td class="tdCaja"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>