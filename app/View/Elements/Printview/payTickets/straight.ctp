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
    body {font-family:Arial, Helvetica, sans-serif; font-size:11px; color: #000000;}
    .center {text-align:center}

    .containerP{
        border: thin solid #000000;
        margin-bottom: 15px
    }
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

    #details {font-size:11px; line-height: 9px;}

    #tickettotals {margin:0.5em; vertical-align: middle; font-weight: bold; }
    #tickettotals p { border-bottom: thin dotted #000000; padding-bottom: 0.5em; line-height: 0.1em}
    h4 {line-height: 0.5em; font-size:11px}

    hr.line {border-top: 1px solid}

    #disclaimer {margin:0.5em; vertical-align: middle;}

</style>
<script>
    $(document).ready(function () {
//        JsBarcode(".barcode").init();
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
</script> 

<div id="printButton" class="panel-body text-center">
    <button class="btn btn-warning" style="width: 100%; margin-bottom: 20px;font-size: 20px;font-weight:bold;background-color: #FFDF1B" type="button" onclick="window.print()">Imprimir</button> 
</div>

    
    <div id="payTicket" class="col-md-4 center-block containerP">
        <h2 class="center"><?= $generalInfo["siteDesc"] ?></h2>
        <div id="header">
            <p class="center">Usuario: <?= $generalInfo["username"] ?> - Caja: <?= $generalInfo["caja"] ?></p>
        </div>

        <div id="first">
            <p class="center"></p>
        </div>

        <div id="second">
            <p class="center">Fecha de Pago</p>
        </div>

        <div id="third">
            <p class="center"></p>
        </div>


        <div id="firstb">
            <p class="center"></p>
        </div>

        <div id="secondb">
            <p class="center"><?= date("Y-m-d H:i:s") ?></p>
        </div>

        <div id="thirdb">
            <p class="center"></p>
        </div>

        <div id="break">
        </div>

        <div>
    <?php
        $total_ToPay = 0;
        $total_ret=0;
        foreach ($generalInfo["ticketInfo"] as $ticket) {
            $retAmount=$ticket["Won"]*$generalInfo["retention"];
            $retencion=($ticket["Won"]-$retAmount);
            $total_ToPay+=$retencion;
            $total_ret+=$retAmount;
    ?>
            <div class="ticket"> 
                <span># Ticket:&nbsp;<?= $ticket["TicketNumber"] ?></span>
                <h4 class="center" id="details"><?= $ticket["Description"] ?></h4>
                <p id="details"><?= $ticket["PostedDateTime"] ?></p>
                <p style="margin: 0px">Ganado <span class="alignright"><b><?php echo $currency; ?> <?= round($ticket["Won"], 2) ?></b></span></p>
                <p style="margin: 0px">Retencion <span class="alignright"><?php echo $currency; ?>&nbsp;<?= round($retAmount, 2) ?></span></p>
                <p style="border:none; margin: 0px">Sub Total <span class="alignright"><?php echo $currency; ?> <?=round($retencion,2) ?></span></p>
            </div>
        </div>
         <?php } ?>
        <div id="tickettotals">
            <p>Total Retenido <span class="alignright"><?php echo $currency; ?>&nbsp;<?= round($total_ret, 2) ?></span></p>
            <h3>Total A pagar <span class="alignright"><b><?php echo $currency; ?> <?= round($total_ToPay, 2) ?></b></span></h3>
        </div>
        <hr class="line" />
        <center>
            <div id="disclaimer">
                <b>Gracias por Jugar con nosotros</b>
            </div>
        </center>
    </div>

