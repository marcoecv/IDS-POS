<?php
if(isset($compressedData)){
	?>
	<script>
		var compressedData='<?php echo $compressedData?>';
	</script>
	<?php
}
?>
<script>
    var _CUSTOMER_INFO = <?php echo json_encode($usersAuth['fullCustomerInfo']); ?>;
	var _CUSTOMER_ADMIN = <?php echo json_encode($usersAuth['accessAdmin']); ?>;
	var _LIVEBET_STATUS = <?php echo json_encode($usersAuth["liveBetStatus"]); ?>;
	var _CASINO_STATUS = <?php echo json_encode($usersAuth["casinoStatus"]); ?>;
	var _HORSE_STATUS = <?php echo json_encode($usersAuth["horseStatus"]); ?>;
	var _THEME = '<?php echo $this->App->getDomain('theme'); ?>';
</script>