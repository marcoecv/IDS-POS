<script>  
    $(document).ready(function(){
        var customerLogged = '<?php echo $customer; ?>';
        if($('#globalcustomer').val() == ''){
            $('#globalcustomer').val(customerLogged)
        }
    })
</script>
<?php
    $this->Html->css('admin/site', array('inline' => false));
    echo $this->Html->script('admin/personal/personal');
    echo $this->Html->script('admin/site/site');
    echo $this->element('confirmationmodal', array('message' => 'There are no records for the parameters used!!'));
    echo $this->element ('loadingModal');
    echo $this->element('topmenu_account');
    echo $this->Session->flash();
?>

<style>
    .form-control{
         height:30px;
    }
    
    .panel-body{
         padding-bottom:3px;
         padding-top: 3px;
    }
    
    .panel{
         margin-bottom: 4px;
    }
</style>

<div id="content" class="tab-content">
    <?php
    if($this->App->it_has_permission('PreGame') ||
       $this->App->it_has_permission('Casino') ||
       $this->App->it_has_permission('Live')){
        $rolStatus = array(
            'PreGame'=> $this->App->it_has_permission('PreGame'),
            'Casino'=> $this->App->it_has_permission('Casino'),
            'Live'=> $this->App->it_has_permission('Live'));
        echo $this->element ( 'Personal/status' , array('rolStatus' => $rolStatus));
    }
    ?>
    <?php echo $this->element('Site/setup'); ?>
</div>
<script>
    $(document).ready(function(){
        $('.datepicker').datepicker();
    });
</script>