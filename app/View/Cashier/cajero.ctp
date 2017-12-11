<?php echo $this->Html->script('admin/cashier/cajero'); ?>
<?php echo $this->Html->script('admin/cashier/deposit'); ?>
<?php echo $this->Html->script('admin/cashier/cerrarcaja'); ?>
<?php echo $this->Html->script('admin/cashier/payticket');?>
<?php echo $this->Html->script('admin/cashier/deletetickets');?>
<?php echo $this->Html->script('admin/cashier/reprinttickets');?>
<?php echo $this->Html->script('admin/cashier/reprinttrans');?>

<?php echo $this->element('Cashier/modals/confirmdepositmodal'); ?>
<?php echo $this->element('Cashier/modals/newwithdrawmodal'); ?>
<?php echo $this->element('Cashier/modals/abrircajamodal'); ?>
<?php echo $this->element('Cashier/modals/retirarcaja'); ?>
<?php echo $this->element('Cashier/modals/depositarcaja'); ?>
<?php echo $this->element('Cashier/modals/desbloquearcajamodal'); ?>

<?php echo $this->Html->css('admin/cashier/deposit'); ?>
<?php echo $this->Html->css('admin/cashier/cerrarcaja'); ?>
<?php echo $this->Html->css('admin/cashier/payticket');?>
<?php echo $this->Html->css('admin/cashier/cajero');?>
<?php echo $this->Html->css('admin/cashier/deletetickets');?>
<?php echo $this->Html->css('admin/cashier/reprinttickets');?>
<?php echo $this->Html->css('admin/cashier/reprinttrans');?>

<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div id="cajero_leftBox" class="col-md-7" style="padding: 0 1px !important;">
        <?php echo $this->element('Cashier/leftPanels/deposit'); ?>
        
        <?php echo $this->element('Cashier/leftPanels/cerrarcaja'); ?>
        
        <?php echo $this->element('Cashier/leftPanels/payticket'); ?>
        
        <?php echo $this->element('Cashier/leftPanels/deletetickets'); ?>
        
        <?php echo $this->element('Cashier/leftPanels/reprinttickets'); ?>
        
        <?php echo $this->element('Cashier/leftPanels/reprinttrans'); ?>
    </div>
    <div  id="cajero_centerBox"class="col-md-3" style="padding: 0 1px !important;">
        <div class="box" style="height: 680px">
            <div class="box-header">
                <button class="btn btn-default btntac" type="button" disabled="" style="width: 100%;margin: auto">
                    <span>Disponible:</span>
                </button>
                <input type="hidden" id="anonimAccount" value="<?=$anonimAccount?>"/>
            </div>
            <div class="row">
                <hr style="margin: 5px 10px 5px 10px; border-color: #0c0c0c">
            </div>
            <div class="box-body" style="height:100%;padding: 0px">
                <?php echo $this->element('Cashier/centerPanels/numericKeyboard'); ?>
                
                <?php echo $this->element('Cashier/centerPanels/cierrecajapanel'); ?>
                
                <?php echo $this->element('Cashier/centerPanels/payticketpanel'); ?>
                
                <?php echo $this->element('Cashier/centerPanels/deletepanel'); ?>
                
                <?php echo $this->element('Cashier/centerPanels/reprintpanel'); ?>
                
                <?php echo $this->element('Cashier/centerPanels/reimprimirtrans'); ?>
            </div>
        </div>
    </div>
    <div  id="cajero_rightBox" class="col-md-2" style="padding: 0 1px !important;">
        <div class="box" style="height: 680px" >
            <div class="box-header">
                <button class="btn btn-default btntac" type="button" disabled="" style="width: 100%;margin: auto">
                    $<span id="cajaBal">0.00</span>
                </button>
            </div>
            <div class="row">
                <hr style="margin: 5px 10px 5px 10px; border-color: #0c0c0c">
            </div>
            <div class="box-body" id="c_actionButtons" style="height:100%;padding: 0px">
                <?= $buttonsPermission ?>
            </div>
        </div>
    </div>




</div>





