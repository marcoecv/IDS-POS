<?php 
    echo $this->Html->script('admin/pvReports/linesreport');
    echo $this->Html->script('plugins/table2Excel/jquery.table2excel.min');
    echo $this->Html->css('admin/pvReports/linesreport');
    echo $this->Html->script('admin/pvReports/pvReportTools');
?>
<?php $this->assign('title', 'Reporte de Lineas'); ?>

<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Reporte de Lineas</h3>
                    </div>
                    <div class="col-md-6">
                        <button id="mc_export"  class="btn btn-info btn-flat btn-lg" onclick="exportToExcel('lr_table')" style="width: 100%;height: 48px;font-size: 22px;"type="button" ><i class="glyphicon glyphicon-export"></i> Excel</button>
                    </div>
                    <hr style="margin: 0px 7px 0px 7px; border-color: #0c0c0c">
                </div>
            </div>
            <div class="box-body">
                <div id="lr_tableHeaderDiv" class="col col-md-12">
                    <table id="lr_headerTable" class="table table-bordered  table-striped table-hover" style="">
                        <tr>
                            <th class="tdSubSport">Sub Deporte</th>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdRot"># Rot</th>
                                <th class="tdEquipo">Equipo</th>
                                <th class="tdSpread">Spread</th>
                                <th class="tdMoney">MoneyLine</th>
                                <th class="tdTotal">Total</th>
                                <th class="tdTeamTotal">Team Total O</th>
                                <th class="tdTeam">Team Total U</th>
                        </tr>
                    </table>
                </div>
                <div id="lr_tableDiv" class="col col-md-12">
                    <table id="lr_table" class="table table-bordered  table-striped table-hover" border="1" style="">
                        <thead style="display: none">
                            <tr>
                                <th class="tdSubSport">Sub Deporte</th>
                                <th class="tdFecha">Fecha/Hora</th>
                                <th class="tdRot"># Rot</th>
                                <th class="tdEquipo">Equipo</th>
                                <th class="tdSpread">Spread</th>
                                <th class="tdMoney">MoneyLine</th>
                                <th class="tdTotal">Total</th>
                                <th class="tdTeamTotal">Team Total O</th>
                                <th class="tdTeamTotal">Team Total U</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $currentSport="";
                            $currentSubSport="";
                            foreach ($lines as $line){
                                if($currentSport!=$line["SportType"]){
                                    $currentSport=$line["SportType"]
                                ?>
                            <tr>
                                <td colspan="9" class="tdSportTitle"><?=$line["SportType"]?></td>
                            </tr>
                                <?php    
                                }
                                $subSport="";
                                if($currentSubSport!=$line["SportSubType"]){
                                    $subSport=$line["SportSubType"];
                                    $currentSubSport=$line["SportSubType"];
                                }else{
                                    $subSport="";
                                }
                                $tr1="";
                                $tr2="";
                                $tr3="";
                                if($line["MoneyLineDraw"]!=null&&$line["MoneyLineDraw"]!=""&&$line["MoneyLineDraw"]!="0"){
                                    $tr1="border-top: solid black 2px;border-left: solid black 2px;border-right: solid black 2px;";
                                    $tr2="border-left: solid black 2px;border-right: solid black 2px;";
                                    $tr3="border-left: solid black 2px;border-right: solid black 2px;border-bottom: solid black 2px;";
                                }else{
                                    $tr1="border-top: solid black 2px;border-left: solid black 2px;border-right: solid black 2px;";
                                    $tr2="border-left: solid black 2px;border-right: solid black 2px;border-bottom: solid black 2px;";
                                }
                                $tdSubSport=$subSport;
                                $tdFecha=$line["GameDate"]."<br/>".$line["GameTime"];
                                $tdRot=$line["Team1RotNum"]."<br/>".$line["Team2RotNum"];
                                $tdEquipo=$line["Team1ID"]."<br/>".$line["Team2ID"];
                                if(trim($line["Team1ID"])==trim($line["FavoredTeamID"]))
                                    $tdSpread=$line["Spread"]." ".$line["SpreadAdj1"]."<br/>".$line["SpreadAdj2"];
                                else
                                    $tdSpread=$line["SpreadAdj1"]."<br/>".$line["Spread"]." ".$line["SpreadAdj2"];
                                $tdMoney=$line["MoneyLine1"]."<br/>".$line["MoneyLine2"];
                                if($line["MoneyLineDraw"]!=null&&$line["MoneyLineDraw"]!=""&&$line["MoneyLineDraw"]!="0"){
                                   $tdMoney.="<br/>".$line["MoneyLineDraw"];
                                   $tdEquipo.="<br/>Draw";
                                }
                                $tdTotal=$line["TotalPoints"]." ".$line["TtlPtsAdj1"]."<br/>".$line["TtlPtsAdj2"];
                                $tdTeamTotalO="O ".$line["Team1TotalPoints"]." ".$line["Team1TtlPtsAdj1"]."<br/>"."O ".$line["Team2TotalPoints"]." ".$line["Team2TtlPtsAdj1"];
                                $tdTeamTotalU="U ".$line["Team1TotalPoints"]." ".$line["Team1TtlPtsAdj2"]."<br/>"."U ".$line["Team2TotalPoints"]." ".$line["Team2TtlPtsAdj2"];
                                ?>
                            
                            <tr style="border:solid black 2px; text-align: center">
                                <td class="tdSubSport"><?=$tdSubSport?></td>
                                <td class="tdFecha"><?=$tdFecha?></td>
                                <td class="tdRot"><?=$tdRot?></td>
                                <td class="tdEquipo"><?=$tdEquipo?></td>
                                <td class="tdSpread"><?=$tdSpread?></td>
                                <td class="tdMoney"><?=$tdMoney?></td>
                                <td class="tdTotal"><?=$tdTotal?></td>
                                <td class="tdTeamTotal"><?=$tdTeamTotalO?></td>
                                <td class="tdTeamTotal"><?=$tdTeamTotalU?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




