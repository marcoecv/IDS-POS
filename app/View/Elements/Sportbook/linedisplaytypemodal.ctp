<?php
	$menuOptions = $this->App->getDomain('MenuOptions');
?>
<div class="modal fade" id="lineDisplayTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span class="modal-title"><?php echo __('Settings');?></span><span class="modal-title" id="ticketNum"></span>
                    </div>
                    <div class="modal-body">
							<?php if($this->App->it_has_permission_config_user('MenuOptions','Line_Type_Format')){ ?>
							<div class='sectionSettings'>
								<h4><?php echo __('Line Type Format');?></h4>
								<?php //$lineTypeFormat = $this->App->getDomain('LineTypeFormat'); ?>
								<div class='table'>
									<div class='row'>
										<label for="ltdm_american"><?php echo __('American');?></label>
										<input type="radio" id="ltdm_american" value="A" name="ltdm_format" />
									</div>
									<div class='row'>
										<label for="ltdm_decimal"><?php echo __('Decimal');?></label>
										<input type="radio" id="ltdm_decimal" value="A" name="ltdm_format" />
									</div>
								</div>
							</div>
							<?php } ?>
							<?php if($this->App->it_has_permission_config_user('MenuOptions','Languages')){ ?>
							<div class='sectionSettings'>
								<?php $language = $this->App->getDomain('Language');  ?>
								<h4><?php echo __('Languages');?></h4>
								<div class='table'>
									<div class='row'>
										<label for="lang_eng">English</label>
										<input type="radio" id="lang_eng" value="eng" name="lang" />
									</div>
									<div class='row'>
										<label for="lang_esp">Español</label>
										<input type="radio" id="lang_esp" value="esp" name="lang" />
									</div>
									<div class='row'>
										<label for="lang_fra">Français</label>
										<input type="radio" id="lang_fra" value="fra" name="lang" />
									</div>
									
								</div>
							</div>
							<?php } ?>
                    </div>
			<div class="modal-footer">
				<button type="button" id="ltdm_changeLineFormat" class="btn btn-success" data-dismiss="modal"><?php echo __('Change');?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
			</div>
		  </div>
	</div>
</div>


<script>
$(document).ready(function(){
	<?php
	if(isset($_COOKIE["Language"])){ ?>
	var currentLang = "<?php echo $_COOKIE["Language"]; ?>"
		$('input[value="'+currentLang+'"]').prop('checked', true);
	<?php } ?>
	
	var type = $.trim(readCookie("LineTypeFormat"));
	switch (type) {
		case "American":
			$("#ltdm_american").prop("checked", true);
			createCookie('CurrentTypeFormat', 'A', '');
			break;
		case "Decimal":
			$("#ltdm_decimal").prop("checked", true);
			createCookie('CurrentTypeFormat', 'D', '');
			break;
	}
	
	var lan = readCookie("Language");
	switch (lan) {
		case "English":
			$("#lang_eng").prop("checked", true);
			createCookie('CurrentLang', 'eng', '');
			break;
		case "Español":
			$("#lang_esp").prop("checked", true);
			createCookie('CurrentLang', 'esp', '');
			break;
		case "Français":
			$("#lang_fra").prop("checked", true);
			createCookie('CurrentLang', 'fra', '');
			break;
	}
});
</script>
									
									

