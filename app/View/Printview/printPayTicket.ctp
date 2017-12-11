<?php echo $this->Html->script('jquery-2.2.3.min'); ?>
<?php echo $this->Html->script('plugins/JsBarcode.all.min'); ?> 
<style type="text/css" media="print">
    @page {
        size: 75.88mm 80mm !important;
        margin: 0mm 15mm 0mm 0mm; /* change the margins as you want them to be. */
    }
    body header, footer, nav, aside {
        display: none !important
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
        font-size: 11px;
    }
</style>
<style>
    .price {
        display: block;
        font-size: 30px;
        line-height: 0px;
    }

    .price sup {
        top: -20px;
        left: 2px;
        font-size: 20px;
    }

    .period {
        display: block;
        font-style: italic;
    }

    .label {
        font-weight: normal;
    }


    /*          bootstrap styles here for print           */

    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        color: inherit;
        font-family: inherit;
        font-weight: 500;
        line-height: 1.1;
    }


    /*                 panel                  */

    .panel-primary {
        border-color: #337ab7;
    }

    .panel {
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .panel-primary > .panel-heading {
        background-color: #337ab7;
        border-color: #337ab7;
        color: #fff;
    }

    .panel-heading {
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        padding: 5px;
    }

    .panel > .list-group, .panel > .panel-collapse > .list-group {
        margin-bottom: 0;
    }


    /*                 list                  */


    .list-group {
        margin-bottom: 20px;
        padding-left: 0;
    }
    ol, ul {
        margin-bottom: 10px;
        margin-top: 0;
    }

    .list-group-item {
        background-color: #fff;
        border: 1px black dashed;
        display: block;
        margin-bottom: -1px;
        padding: 2px 0px 0px 10px;
        position: relative;
    }

    .list-group-item-info {
        background-color: #d9edf7;
        color: #31708f;
    }

    .list-group-item-success {
        background-color: #dff0d8;
        color: #3c763d;
    }


    /*                 btn                    */

    .btn-info {
        background-color: #5bc0de;
        border-color: #46b8da;
        color: #fff;
    }

    .btn-primary {
        background-color: #337ab7;
        border-color: #2e6da4;
        color: #fff;
    }

    .btn {
        -moz-user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857;
        margin-bottom: 0;
        padding: 6px 12px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }


        </style>
        <script>
        $(document).ready(function() {
            JsBarcode(".barcode").init();
        });
        
        function printTicket(ticket){
            
            var mywindow = window.open('', 'my div', 'height=400,width=600');
            mywindow.document.write('<html><head><title>my div</title>');
            /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
            mywindow.document.write('</head><body >');
            mywindow.document.write(document.getElementById("mainTicket_"+ticket).innerHTML);
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
    <button class="btn btn-md btn-info" style="width: 100%" type="button" onclick="window.print()">Print</button> 
</div>
<?php
foreach ($ticketInfo as $ticket){
?>
<div id="mainTicket_<?=$ticket->ticketNumber?>" class="col-md-4 center-block">
    <div class="panel panel-primary ">
        <div class="panel-heading" style="text-align: center">
            <h3 class="price"><b><?=$siteDesc?></b></h3>
        </div>
        <ul class="list-group">
            <li class="list-group-item"><strong><?=$ticket->title?></strong></li>
            <?php
            foreach ($ticket->items as $item){
                $count=1;
                if($ticket->title!="Straight"){?>
                    <li class="list-group-item"><b>Seleccion #<?=$count?></b></li>
                <?php
                }
                ?>
                <li class="list-group-item"><?=$item->sportDescription?></li>
                <li class="list-group-item"><?=$item->chosenTeam?></li>
                <li class="list-group-item"><?=$item->line?></li>
                <?php if($ticket->title=="Straight"){?>
                    <li class="list-group-item">Riesgo: <b><?=$item->risk?></b>&nbsp;&nbsp; Gane: <b><?=$item->win?></b></li>
                <?php 
                }
                ?>
                <li class="list-group-item">Fecha del Evento: <?=$item->gameDate?></li>
            <?php
            $cont++;
            }
            ?>
            <?php if($ticket->title!="Straight"){?>
                <li class="list-group-item">Riesgo: <b><?=$ticket->globalRisk?></b>&nbsp;&nbsp; Gane: <b><?=$ticket->globalWin?></b></li>
            <?php 
            }
            ?>
            <li class="list-group-item">Fecha de Emision: <?=date("Y-m-d H:i:s")?></li>
            <li class="list-group-item">Usuario: <b><?=$username?></b> Caja: <?=$caja?></li>
        </ul>
        <center>
            <div id="codeDiv_<?=$ticket->ticketNumber?>" class="panel-body text-center">
                <svg class="barcode" jsbarcode-width="2" jsbarcode-height="45" jsbarcode-format="CODE128" jsbarcode-value="<?=$ticket->ticketNumber?>" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold"></svg>
            </div>
        </center>
        
    </div>
</div>
<br/>
<?php 
}
?>
 