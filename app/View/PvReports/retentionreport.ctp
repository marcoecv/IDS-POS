<?php 
    echo $this->Html->script('angular.min');
    echo $this->Html->script('admin/pvReports/pvReportTools');
    echo $this->Html->script('admin/pvReports/retentionreport');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/retentionreport');
    echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
    echo $this->Html->script('plugins/bootstrap-datetimepicker');
?>
<?php
$this->assign('title', 'Reporte de Retenciones');
?>

<div ng-app="app" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3>Reporte de Retenciones</h3>
    <div ng-controller="retentionController" class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-1">
                        <label for="rr_dateIni" class="control-label editGameLabelWith">Desde: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input ng-model="dateIni" class="form-control" name="rr_dateIni" id="rr_dateIni" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="rr_dateEnd" class="control-label editGameLabelWith">Hasta: </label>
                        <div class="date form_datetime input-group col-md-5" id='mc_initdateDiv' style="width: 100%;">
                            <input ng-model="dateEnd" class="form-control" name="rr_dateEnd" id="rr_dateEnd" size="16" type="text" value="" readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Tipo Cuenta: </label>
                        <select id="rr_tipo" class="form-control" style="width: 100%">
                            <option value=""></option>
                            <option value="1" selected="true">Todo</option>
                            <option value="2">Cuenta</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label>Cuenta: </label>
                        <input ng-model="cuenta" type="text" id="rr_cuenta" class="form-control pull-right" readonly />
                    </div>
                    <div class="col-md-1">
                        <button id="rr_searchTrans" ng-click="getData()" type="button" class="btn btn-info btn-flat btn-lg"
                                style="width: 100%;height: 48px;font-size: 26px;"><i
                                class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button id="rr_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('rr_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
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
                <div id="rr_tableHeaderDiv" class="col col-md-12">
                    <table id="rr_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdTicket"># Ticket</th>
                            <th class="tdTrans"># Transaccion</th>
                            <th class="tdDate">Fecha</th>
                            <th class="tdCuenta">Cuenta</th>
                            <th class="tdWon">Monto Ganado</th>
                            <th class="tdTax"> Porcentaje Aplicado</th>
                            <th class="tdReten">Total Retenido</th>
                        </tr>
                    </table>
                </div>
                <div id="rr_tableDiv" class="col col-md-12">
                    <table id="rr_table" class="table table-bordered  table-striped table-hover" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdTicket"># Ticket</th>
                                <th class="tdTrans"># Transaccion</th>
                                <th class="tdDate">Fecha</th>
                                <th class="tdCuenta">Cuenta</th>
                                <th class="tdWon">Monto Ganado</th>
                                <th class="tdTax"> Porcentaje Aplicado</th>
                                <th class="tdReten">Total Retenido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="ret in retentions">
                                <td class="tdTicket">{{ret.TicketNumber}}</td>
                                <td class="tdTrans">{{ret.DocNum}}</td>
                                <td class="tdDate">{{ret.TranDate}}</td>
                                <td class="tdCuenta">{{ret.CustomerID}}</td>
                                <td class="tdWon">{{ret.AmountWon}}</td>
                                <td class="tdTax">{{ret.TaxPercent}}%</td>
                                <td class="tdReten">{{ret.AmountTax}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="tdTicket">Totals:</td>
                                <td class="tdTrans"></td>
                                <td class="tdDate"></td>
                                <td class="tdCuenta"></td>
                                <td class="tdWon">{{totalWon}}</td>
                                <td class="tdTax"></td>
                                <td class="tdReten">{{totalRet}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




