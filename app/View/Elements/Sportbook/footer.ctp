<!--<div id='footer'>
	<div class='panel panel-default'>
		<div class='row'>
			<center>
				<div class='panel-body'>
					<div class='col-xs-12 col-sm-4'>
						<dl>
							<dt><?php echo __('Betting Links');?></dt>
							<dd><?php echo __('Pre-Game');?></dd>
							<dd><?php echo __('Live');?></dd>
							<dd><?php echo __('Horses');?></dd>
							<dd><?php echo __('Casino');?></dd>
						</dl>
					</div>
					<div class='col-xs-12 col-sm-4'>
						<dl>
							<dt><?php echo __('Reports');?></dt>
							<dd><?php echo __('Pending');?></dd>
							<dd><?php echo __('Daily Figures');?></dd>
							<dd><?php echo __('Weekly Figures');?></dd>
							<dd><?php echo __('Account History');?></dd>
						</dl>
					</div>
					<div class='col-xs-12 col-sm-4'>
						<dl>
							<dt><?php echo __("FAQ's");?></dt>
							<dd><?php echo __('iPlay');?></dd>
							<dd><?php echo __('Live');?></dd>
							<dd><?php echo __('Official Rules');?></dd>
						</dl>
					</div>
				</div>
			</center>
		</div>
	</div>
</div>-->
<footer>
    <div class="copy-rights clearfix">
        <div class="pull-center">
			<?php
				$nameClient = $this->App->getDomain('nameClient');
				$theme = $this->App->getDomain('theme'); 
			?>
            Copyright &copy; 2016 <?php echo __('All rights reserved for').' '.(isset($nameClient) && $nameClient != "" ? $nameClient : $theme); ?>
        </div>
    </div>
</footer>
<style>
	#tawkchat-minified-wrapper{
		display: none; 
	}
</style> 