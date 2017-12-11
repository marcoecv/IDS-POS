<script>  
    $(document).ready(function(){
        var customerLogged = '<?php echo $customer; ?>';
        if($('#globalcustomer').val() == ''){
            $('#globalcustomer').val(customerLogged)
        }
    })
</script>
<?php

echo $this->Html->script('admin/personal/personal');
echo $this->Html->script('admin/personal/personal');
$this->Html->css('admin/account', array('inline' => false));

echo $this->element('confirmationmodal', array('message' => 'There are no records for the parameters used!!'));
echo $this->element('topmenu_account', array('globalCustomer', $globalCustomer));
?>

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
    <?php echo $this->element ('Personal/info'); ?>
</div>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker();
        $('.datepicker2').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:2016',
            dateFormat: 'yy-mm-dd'
        });
       
    });
    

</script>