<?php echo $this->Html->script('jquery-2.2.3.min'); ?>
<?php echo $this->Html->script('plugins/JsBarcode.all.min'); ?> 

<style type="text/css" media="print">
    @page {
        size: 75.88mm 80mm !important;
        margin: 0mm 0mm 0mm 0mm !important; /* change the margins as you want them to be. */
    }
    body header, footer, nav, aside {
        display: none !important
    }

    .pv_footertxt{
        padding: 0;
        margin: 0;
        font-size: 11px;
    }
    #printButton{
        display: none !important
    }

    #mainTicket{
        border: 1px black dotted;
        width: 100%;
        display: block;
        page-break-after: always;

    }
    .list-group-item{
        font-size: 16px;
    }
    .price{
        font-size: 40px;
    }
</style>
<style>
    body {font-family:Arial, Helvetica, sans-serif; font-size:11px; color: #000000;border: thin solid #000000;}
    .center {text-align:center}


    #header{border-bottom: dotted; border-bottom-width: 1px;}
    #header p {line-height:0.5em}

    #first {
        float: left;
        width: 33%;
        border-bottom: dotted; border-bottom-width: 1px;
        height: 2em;
        line-height:0.5em;
        display: table	
    }
    #first p {display: table-cell;vertical-align: middle;}

    #second {
        float: left;
        width: 32%;
        border-bottom: dotted; border-bottom-width: 1px;
        border-left: dotted; border-left-width: 1px;
        border-right: dotted; border-right-width: 1px;
        height: 2em;
        line-height:0.5em;
        display: table
    }
    #second p {display: table-cell;vertical-align: middle;}

    #third {
        float: left;
        width: 33%;
        border-bottom: dotted; border-bottom-width: 1px;
        height: 2em;
        line-height:0.5em;
        display: table
    }
    #third p {display: table-cell;vertical-align: middle;}

    #firstb {
        float: left;
        width: 33%;
        border-bottom: dotted; border-bottom-width: 1px;
        height: 3em;
        line-height:0.5em;
        display: table
    }
    #firstb  p {display: table-cell;vertical-align: middle;}

    #secondb {
        float: left;
        width: 32%;
        border-bottom: dotted; border-bottom-width: 1px;
        border-left: dotted; border-left-width: 1px;
        border-right: dotted; border-right-width: 1px;
        height: 3em;
        line-height:1em;
        display: table
    }
    #secondb p {display: table-cell;vertical-align: middle;}

    #thirdb {
        float: left;
        width: 33%;
        border-bottom: dotted; border-bottom-width: 1px;
        height: 3em;
        line-height:0.5em;
        display: table
    }
    #thirdb p {display: table-cell;vertical-align: middle;}


    #break {
        clear: both;
    }

    .ticket {border: thin solid #000; padding: 0.5em 0.5em 0 0.5em; margin:0.5em;}

    .alignright {float:right;}

    h2 {line-height: 0.5em;}

    #details {font-size:11px; line-height: 0.5em;}

    #tickettotals {margin:0.5em; vertical-align: middle; font-weight: bold; }
    #tickettotals p { border-bottom: thin dotted #000000; padding-bottom: 0.5em; line-height: 0.1em}
    h4 {line-height: 0.5em; font-size:11px}

    hr.line {border-top: 1px solid}

    #disclaimer {margin:0.5em; vertical-align: middle;}

</style>
<script>
    $(document).ready(function () {
        JsBarcode(".barcode").init();
    });

    function printTicket(ticket) {

        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById("mainTicket_" + ticket).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
    //function generateCode(ticketNum){
    //   JsBarcode("#barcode"+ticketNum, ticketNum, {
    //  format: "pharmacode",
    //  lineColor: "#0aa",
    //  width: 4,
    //  height: 40,
    //  displayValue: false
    //});
    //}
</script> 
<div id="printButton" class="panel-body text-center">
    <button class="btn btn-warning" style="width: 100%; margin-bottom: 20px;font-size: 20px;font-weight:bold;background-color: #FFDF1B" type="button" onclick="window.print()">Imprimir</button> 
</div>
<?php
$count = 1;
    ?>
    <h2 class="center"><?= $generalInfo["siteDesc"] ?></h2>

    <div id="mainTicket_<?=$generalInfo["ticketInfo"]["row1"]["TicketNumber"]?>" class="col-md-4 center-block containerP">

        <div id="header">
            <p class="center">Usuario: <?= $generalInfo["username"] ?> - Caja: <?= $generalInfo["caja"] ?></p>
        </div>

        <div id="first">
            <p class="center">ID</p>
        </div>

        <div id="second">
            <p class="center">Fecha</p>
        </div>

        <div id="third">
            <p class="center">Tipo</p>
        </div>


        <div id="firstb">
            <p class="center"><?=$generalInfo["ticketInfo"]["CustomerID"]?></p>
        </div>

        <div id="secondb">
            <p class="center"><?= date("Y-m-d H:i:s") ?></p>
        </div>

        <div id="thirdb">
            <p class="center"><?= $generalInfo["ticketInfo"]["row1"]["BetType"]?></p>
        </div>

        <div id="break">
        </div>

        <div>
            <?php
            $cuota=1;
            foreach ($generalInfo["ticketInfo"] as $ticket){
                $cuota*=$ticket["FinalDecimal"]
            ?>
            <div class="ticket"> 
                <?php 
                    $pitcher1 = "";
                    $pitcher2 = "";
                    if ($ticket["ListedPitcher1"] != "") {
                        $pitcher1 = " " . $ticket["ListedPitcher1"];
                        if ($ticket["Pitcher1ReqFlag"] == "Y") {
                            $pitcher1.="(Must Start)";
                        } else if ($ticket["Pitcher1ReqFlag"] == "N") {
                            $pitcher1.="(Action)";
                        }
                    }
                    if ($ticket["ListedPitcher2"] != "") {
                        $pitcher2 = " " . $ticket["ListedPitcher2"];
                        if ($ticket["Pitcher2ReqFlag"] == "Y") {
                            $pitcher2.="(Must Start)";
                        } else if ($ticket["Pitcher2ReqFlag"] == "N") {
                            $pitcher2.="(Action)";
                        }
                    }
                    ?>
                    <span><?= $ticket["SportType"] . " " . $ticket["SportSubType"] ?></span><br />
                    <span><?= $ticket["Team1RotNum"] . " " . $ticket["Team1ID"] . $pitcher1 ?></span> VS <span><?= $ticket["Team2RotNum"] . " " . $ticket["Team2ID"] . $pitcher2 ?></span><br />
                    <?php
                    $linesDesc = "";
                    $wagerType = "";
                    switch ($ticket["WagerTypeByLine"]) {
                        case "S":
                            $wagerType = "Spread";
                            $linesDesc = $ticket["AdjSpread"];
                            break;
                        case "M":
                            $wagerType = "MoneyLine";
                            break;
                        case "L":
                            $wagerType = "Total";
                            $linesDesc = $ticket["AdjTotalPoints"];
                            break;
                        case "E":
                            $wagerType = "Team Total";
                            $linesDesc = $ticket["AdjTotalPoints"] . " " . ($ticket["TotalPointsOU"] == "O" ? "Over" : "Under");
                            break;
                    }
                    
                    $line=(substr($ticket["FinalMoney"], 0,1)!="-"?"+".$ticket["FinalMoney"]:$ticket["FinalMoney"]);
                    $selectionDesc = $ticket["PeriodDescription"] . " " . $ticket["ChosenTeamID"] . " " . $linesDesc . " " . $line;
                    ?>    


                    <span><?= $wagerType ?></span>
                    <h4 class="center" id="details"><?= $selectionDesc ?></h4>
                    <p id="details"><?= $ticket["GameDateTime"] ?></p>
                    </div>
                </div>
                        <?php }
                    $count++;
                ?>
            
        </div>
        <div id="tickettotals">
            <p>Cantidad <span class="alignright"><b><?php echo $generalInfo["currency"]; ?> <?= round($ticket["Risk"], 2) ?></b></span></p>
            <p>Gane<span class="alignright"><?php echo $generalInfo["currency"]; ?>&nbsp;<?= round($ticket["ToWinAmount"], 2) ?></span></p>
            <p>Retencion: <span class="alignright" style="color: red;font-weight: bold"><?php echo $generalInfo["currency"]; ?>&nbsp;-<?= $generalInfo["retention"]?>%**</span></p>
            <p style="border:none;">Pago Total <span class="alignright"><?php echo $generalInfo["currency"]; ?> <?= round($ticket["Risk"]+$ticket["ToWinAmount"], 2) ?></span></p>
        </div>
        <hr class="line" />
        <center>
            <div id="codeDiv_<?=$generalInfo["ticketInfo"]["row1"]["TicketNumber"] ?>" class="panel-body text-center" style="width: 100%">
                <svg class="barcode"></svg>
            </div>

            <div id="disclaimer">
                <b>** &nbsp; Esta retencion se aplica solo a las apuestas ganadoras y se hace efectiva al momento de obtener si monto ganado</b>
                <?php
                if ($ticketType == "1") {
                    ?>
                    <p>Al recibir este tiquete el jugador acepta los términos y condiciones asi como las reglas de la casa.<br />Este tiquete tiene una validez de 30 días posteriores a finalizar el evento.</p>
                    <p class="center"><b>Pagadero al portador</b><br />********************</p>
                    <p class="center">No se podrán cancelar ni reembolsar las apuestas realizadas. Sin excepciones.</p>
                <?php } else {
                    ?>
                    <p>Gracias por elegirnos, recuerda ingresar en <b style="text-decoration: underline">www.<?= $siteDesc ?>.com</b>,<br/> 
                        donde encontraras la mayor variedad de oferta y productos para disfrutar donde y cuando quiera, <br/>
                        con solo utilizar su numero de cuenta y su clave.<br/>
                        <b style="text-decoration: underline">www.<?= $siteDesc ?>.com</b></p> 
                    <?php }
                    ?>
            </div>
        </center>
    </div>
    <script>
        JsBarcode("#codeDiv_<?= $ticket["TicketNumber"] ?> .barcode", "<?= $ticket["TicketNumber"] ?>", {
          format: "CODE128",
          width:1,
          height: 40,
          displayValue: true
        });
    </script>