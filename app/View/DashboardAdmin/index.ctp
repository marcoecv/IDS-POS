<?php $this->Html->css('sportbook_icons', array('inline' => false)); ?>
<?php $this->Html->css('admin/dashboardAdmin', array('inline' => false)); ?>
<?php $this->Html->script('plugins/CircularLoader', array('inline' => false)); ?>
<?php $this->Html->script('plugins/Spin.js', array('inline' => false)); ?>
<?php $this->Html->script('admin/dashboardAdmin/dashboardAdmin', array('inline' => false)); ?>

<?php echo $this->element('DashboardAdmin/findaccountmodal'); ?>
<?php echo $this->element('DashboardAdmin/abrircajamodal'); ?>
<?php echo $this->element('DashboardAdmin/adminvalidatemodal'); ?>
<?php echo $this->element('DashboardAdmin/confirmaccountmodal'); ?>
<?php echo $this->element('DashboardAdmin/newaccountmodal'); ?>
<?php echo $this->element('DashboardAdmin/desbloquearcajamodal'); ?>


<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-12">
                <a href="/cashier/cajero">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="button" class="btn btn-block btn-info btn-lg btndash"><?=__('Caja')?></button>
                    </div>
                </a>
                </div>
            </div>
            <div class="box-body" style="height: 575px">
                <div class="col-md-12">
                    <a <?php if ($isOpen) { ?> data-target="#findAccount" data-toggle="modal" href="#findAccount"  <?php } else { ?> onclick="alert('<?=__("Caja Cerrada")?>')" <?php } ?> disabled>
                        <div class="col-md-6 col-md-offset-3">
                            <button type="button" class="btn btn-block btn-success btn-lg btndash"
                                    <?php if (!$isOpen){ ?>disabled<?php } ?>><?=__('Jugador Registrado')?>
                            </button>
                        </div>
                    </a>
                    <a <?php if ($isOpen) { ?> href="/sportbook" <?php } else { ?> onclick="alert('<?=__("Caja Cerrada")?>')" <?php } ?>>
                        <div class="col-md-6 col-md-offset-3">
                            <button type="button" class="btn btn-block btn-success btn-lg btndash"
                                    <?php if (!$isOpen){ ?>disabled<?php } ?>><?=__('Jugador Anonimo')?>
                            </button>
                        </div>
                    </a>
                    <a <?php if ($isOpen) { ?> data-target="#newAccount" data-toggle="modal" href="#newAccount"  <?php } else { ?> onclick="alert('<?=__("Caja Cerrada")?>')" <?php } ?>>
                        <div class="col-md-6 col-md-offset-3">
                            <button type="button" class="btn btn-block btn-success btn-lg btndash"
                                    <?php if (!$isOpen){ ?>disabled<?php } ?>><?=__("Crear Cuenta")?>
                            </button>
                        </div>
                    </a>
                    <a href="/PvReports">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="button" class="btn btn-block btn-success btn-lg btndash"><?=__("Reports")?></button>
                        </div>
                    </a>
                </div>
                    
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>