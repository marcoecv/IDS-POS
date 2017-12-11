<?php 
echo $this->Html->script('angular.min');
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/deletedWagerReport');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/deletedWagerReport');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Apuestas Perdidas');
?>
<div ng-app="app" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Apuestas Borradas</h3>
    <div ng-controller="deletedBetsController" class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="dw_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="dw_dateIni" id="dw_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="dw_initTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="dw_initTime" id="dw_initTime" size="16" type="text" value="00:00"/>
                    </div>
                    <div class="col-md-1">
                        <label for="dw_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input class="form-control" name="dw_dateEnd" id="dw_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="dw_endTime" class="control-label editGameLabelWith">a las: </label>
                        <input class="form-control" name="dw_endTime" id="dw_endTime" size="16" type="text" value="23:59" />
                    </div>
                    <div class="col-md-1">
                        <label>Cuenta: </label>
                        <input type="text" id="dw_cuenta"class="form-control pull-right"/>
                    </div>
                    <div class="col-md-1">
                        <label>Borrado por: </label>
                        <input type="text" id="dw_deletedBy"class="form-control pull-right"/>
                    </div>
                  
                    <div class="col-md-1">
                        <button id="dw_searchTrans" ng-click="getData()" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="dw_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('lb_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
                <div id="dw_tableHeaderDiv" class="col col-md-12">
                    <table id="dw_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdTicket">#Tiquete</th>
                            <th class="tdCuenta">Cuenta</th>
                            <th class="tdDeletedBy">Borrado por</th>
                            <th class="tdDescription">Descripcion</th>
                            <th class="tdRiesgo">Riezgo</th>
                            <th class="tdGanar">Por ganar</th>
                            <th class="tdTipo">Tipo</th>
                            <th class="tdEstado">Estado</th>
                            <th class="tdfechaCreacion">Fecha de Creacion</th>
                            <th class="tdFechaBorrado">Fecha de Borrado</th>
                        </tr>
                    </table>
                </div>
                <div id="dw_tableDiv" class="col col-md-12">
                    <table id="dw_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdTicket">#Tiquete</th>
                                <th class="tdCuenta">Cuenta</th>
                                <th class="tdDeletedBy">Cuenta</th>
                                <th class="tdDescription">Descripcion</th>
                                <th class="tdRiesgo">Riezgo</th>
                                <th class="tdGanar">Por ganar</th>
                                <th class="tdTipo">Tipo</th>
                                <th class="tdEstado">Estado</th>
                                <th class="tdfechaCreacion">Fecha de Creacion</th>
                                <th class="tdFechaBorrado">Fecha de Borrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="bets in deletedBets">
                                <td class="tdTicket">{{bets.TicketNumber}}</td>
                                <td class="tdCuenta">{{bets.CustomerID}}</td>
                                <td class="tdDeletedBy">{{bets.DeletedBy}}</td>
                                <td class="tdDescription">{{bets.Description}}</td>
                                <td class="tdRiesgo">{{bets.AmountWagered}}</td>
                                <td class="tdGanar">{{bets.ToWinAmount}}</td>
                                <td class="tdTipo">{{bets.WagerType}}</td>
                                <td class="tdEstado">{{bets.WagerStatus}}</td>
                                <td class="tdfechaCreacion">{{bets.PostedDateTime}}</td>
                                <td class="tdFechaBorrado">{{bets.DeleteDate}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>