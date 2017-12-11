<?php
	$urlCur = Router::url($this->here, true);
	$urlCur = strtolower($urlCur);
	$protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
	$urlCur = str_replace($protocol, "", $urlCur);
	$urlCur = substr($urlCur, 0, stripos($urlCur, "/"));
	$urlCur = $protocol.$urlCur;
?>

<?php echo $this->Html->script('jquery-1.11.2.min'); ?>
<?php echo $this->Html->script('jquery-ui'); ?>
<?php echo $this->Html->script('../bootstrap/js/bootstrap.min'); ?>
<?php echo $this->Html->script('../bootstrap/js/offcanvas'); ?>
<?php echo $this->Html->script('/js/functions'); ?>

<?php echo $this->Html->css('../bootstrap/css/bootstrap', array('inline' => false)); ?>
<?php echo $this->Html->css('../bootstrap/css/bootstrap-theme.min', array('inline' => false)); ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_header.less" />
<link rel="stylesheet/less" type="text/css" href="<?php echo $urlCur; ?>/css/sportbook_custom.less" />

<?php echo $this->Html->script('/plugins/less/less.min'); ?>

<?php echo $this->Html->css('sportbook_external_app', array('inline' => false)); ?>

<?php echo $this->element('Sportbook/header',array('username'=>$usersAuth['customerId'], 'company'=>$usersAuth['db']));?>
<style>
	body{
		background-color: #000000;
	}
</style>
<div id="divSupport">
	<div>
		<center>
			<div id="divOuter">
				<div id="divInner">
					<div id="myTabContent" class="col-md-9 tab-content" style="">
						<div class="tab-pane fade active in" id="youwager-contact-information">
							<h2 id="contact-information">SportsRoom.ag<br/>Contact Information</h2>
							<h3 id="phone">Phone</h3>
							<p>LIVE PHONE SUPPORT</p>
							<p>10:00 AM EST - 1:00 AM EST 7 DAYS A WEEK.</p>
							<table class="table table-striped table-condensed table-bordered">
								<thead>
									<tr>
										<th>Location</th>
										<th>Number</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Phone Support</td>
										<td>888.303.6626</td>
									</tr>
								</tbody>
							</table>
						
							<h3 id="chat">Live Chat</h3>
							<p>10:00 AM EST - 1:00 AM EST 7 DAYS A WEEK.</p>
							<div id="tawkbutton"></div>
							
							<!--Start of Tawk.to Script-->
							<script type="text/javascript">
								var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
									(function(){
									var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
									s1.async=true;
									s1.src='https://embed.tawk.to/579a49317153f65b6f2dcce6/default';
									s1.charset='UTF-8';
									s1.setAttribute('crossorigin','*');
									s0.parentNode.insertBefore(s1,s0);
							})();
							</script>

							<h3 id="email">Email</h3>
							<table class="table table-striped table-condensed table-bordered">
								<thead>
									<tr>
										<th>Department</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Sports</td>
										<td>support@SportsRoom.ag</td>
									</tr>
									<tr>
										<td>Casino</td>
										<td>support@SportsRoom.ag</td>
									</tr>
									<tr>
										<td>Payouts</td>
										<td>support@SportsRoom.ag</td>
									</tr>
									<tr>
										<td>Live Dealer</td>
										<td>support@SportsRoom.ag</td>
									</tr>
									<tr>
										<td>Horses</td>
										<td>support@SportsRoom.ag</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>	
				</div>
			</div>
		</center>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#navbar li').removeClass('active');
		$("#navbar .nav .mainMenu a .icoSupport").parents(".mainMenu").addClass('active');
    });
</script>
<!--Start of tawk.to Status Code-->

<script type="text/javascript">
	Tawk_API = Tawk_API || {};
	Tawk_API.onStatusChange = function (status){
		if(status === 'online')
		{
			document.getElementById('tawkbutton').innerHTML = '<input type="button" class="submit" id="btnChat" name="btnChat" value="Online - Click to chat" onclick="javascript:void(Tawk_API.toggle());">';
		}
		else if(status === 'away')
		{
			document.getElementById('tawkbutton').innerHTML = 'We are currently away';
		}
		else if(status === 'offline')
		{
			document.getElementById('tawkbutton').innerHTML = 'Live chat is Offline';
		}
	};
</script>
<!--End of tawk.to Status Code -->
<style>
	body.xs .navbar-custom.mobile .nav li a .mainMenuLi .mainMenuContent {
		margin-left: calc((100% - 125px)/2);
	}
	
	#tawkchat-minified-wrapper{
		display: block;  
	}
	
	#tawkbutton input[type="button"] {
		width: 100%;
		padding: 15px;
		border-radius: 5px;
		background-image: -webkit-linear-gradient(top,#337ab7 0,#4E5659 100%);
		background-image: -o-linear-gradient(top,#337ab7 0,#4E5659 100%);
		background-image: -webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#4E5659));
		background-image: linear-gradient(to bottom,#337ab7 0,#4E5659 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff265a88', GradientType=0);
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		background-repeat: repeat-x;
		/* font: 14px Oswald; */
		color: #FFF;
		text-transform: uppercase;
		border: 1px solid #000;
		opacity: 0.7;
		-webkit-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
		-moz-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
		box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
		border-top: 1px solid rgba(255,255,255,0.8)!important;
		-webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(50%, transparent), to(rgba(255,255,255,0.2)));
	}
</style>