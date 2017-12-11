<?php
echo $this->Html->script('/js/slim-scroll/jquery.slimscroll');
echo $this->Html->script('admin/actionPlayer/ActionPlayer');
$this->Html->css('admin/reports', array('inline' => false));
echo $this->element('confirmationmodal', array('message' => 'There are no records for the parameters used!!'));
echo $this->element ('topmenu_reports' );
?>

<div id="reports" class="action-player container-fluid">
<div class='overlay' style="display: none;"></div>
<?php echo $this->element('maintheader', array("pagename" => "Action By Player Report")); ?>
	<?php echo $this->element ( 'ActionPlayer/info' ); ?>
</div>




