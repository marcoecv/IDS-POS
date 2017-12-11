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
<?php echo $this->Html->css('sportbook_external_app', array('inline' => false)); ?>
<?php echo $this->Html->script('/plugins/less/less.min'); ?>

<?php if(isset($usersAuth)){ ?>
<?php echo $this->element('Sportbook/header',array('username'=>@$usersAuth['customerId'], 'company'=>@$usersAuth['db']));?>
<style>
	
</style>
<center>
	<div class="cashierForm">
		<div class="subForm">
			<div class="rowForm">
				<label>METHOD OF PAYMENT</label>
				<select id="cbxMethodPayment" class="methodPayment methodPaymentDefault">
					<option value="Visa">Visa</option>
					<option value="Mastercard">Mastercard</option>
				</select>
			</div>
			<div class="rowForm">
				<label>SUGGESTED DEPOSIT AMOUNT</label>
				<div>
					<button type="button" value="100" id="btnSuggested100" onclick="changeAmount(100);">$100</button>
					<button type="button" value="150" id="btnSuggested150" onclick="changeAmount(150);">$150</button>
					<button type="button" value="250" id="btnSuggested250" onclick="changeAmount(250);">$250</button>
					<button type="button" value="500" id="btnSuggested500" onclick="changeAmount(500);">$500</button>
				</div>
				<div>
					<button type="button" value="750" id="btnSuggested750" onclick="changeAmount(750);">$750</button>
					<button type="button" value="1000" id="btnSuggested1000" onclick="changeAmount(1000);">$1000</button>
					<button type="button" value="1500" id="btnSuggested1500" onclick="changeAmount(1500);">$1500</button>
					<button type="button" value="2000" id="btnSuggested2000" onclick="changeAmount(2000);">$2000</button>
				</div>
			</div>
			<div class="rowForm">
				<div style="float: left; width: 50%;">
					<input type="number" class="amount" placeholder="Deposit Amount" id="txtDepositAmount">
				</div>
				<div style="float: left; width: 50%;padding-top: 10px;">
					<label>($25 Min - $2000 Max)</label>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="rowForm">
				<label>NEW CREDIT/DEBIT CARD NUMBER</label>
				<input type="number" class="amount" placeholder="" id="txtCreditCard1" maxlength="4">
				<input type="number" class="amount" placeholder="" id="txtCreditCard2" maxlength="4">
				<input type="number" class="amount" placeholder="" id="txtCreditCard3" maxlength="4">
				<input type="number" class="amount" placeholder="" id="txtCreditCard4" maxlength="4">
			</div>
			<div class="rowForm">
				<label>EXPIRY DATE:</label>
				<select id="cbxExpiryMonth">
					<option value="-1">Month</option>
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
				<select id="cbxExpiryYear">
					<option value="-1">Year</option>
				</select>
			</div>
			<div class="rowForm">
				<div style="float: left; width: 82%;">
					<input type="number" class="amount" placeholder="Credit Card Verification Number Number" id="txtCCV" maxlength="3">
				</div>
				<div style="float: left;padding-left: 5px;width: 8%;">
					<img src="/images/icoCVV.jpg" alt="CVV" height="35">
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div>
			<button type="button" value="submit" class="btn btn-default" id="btnSubmit" onclick="makeAction();">Submit</button>
		</div>
	</div>
</center>
<?php echo $this->element('confirmationmodal', array('message' => 'Error')); ?>

<script> 
	var _CUSTOMER_INFO = <?php echo json_encode($usersAuth['fullCustomerInfo']); ?>;
	var _CUSTOMER_ADMIN = <?php echo json_encode($usersAuth['accessAdmin']); ?>;
	var _LIVEBET_STATUS = <?php echo json_encode($usersAuth["liveBetStatus"]); ?>;
	var _CASINO_STATUS = <?php echo json_encode($usersAuth["casinoStatus"]); ?>;
	var _HORSE_STATUS = <?php echo json_encode($usersAuth["horseStatus"]); ?>;
	var _THEME = '<?php echo $this->App->getDomain('theme'); ?>';
	var _MENU_OPTIONS = "<?php echo $this->App->getDomain('MenuOptions'); ?>";
	var _INFO_GENERAL = "<?php echo $this->App->getDomain('InfoGeneral'); ?>";
	
	function getCookie(c_name){   
		if (document.cookie.length > 0){
			var c_start = document.cookie.indexOf(c_name + "=");
			if(c_start != -1){
				c_start = c_start + c_name.length + 1;
				c_end = document.cookie.indexOf(";", c_start);
				if(c_end == -1)
					c_end = document.cookie.length;
				return unescape(document.cookie.substring(c_start, c_end));
			}
		}
		return "";
	}
	
	function countSelectionsOnBetslip(){
		var selectionsOnBetslip=getSelectionsOnBetslip();
		var count=0;
		for(var selectionId in selectionsOnBetslip)
		count++;
		return count;
	}
	
	function getSelectionsOnBetslip(){
		var selections1=getCookie('selectionsOnBetslip1');
		var selections2=getCookie('selectionsOnBetslip2');
		var selections3=getCookie('selectionsOnBetslip3');
		var selections=new Object();
		
		try{
		if(selections1!="")
			$.extend(selections, decodeObject(toObject(jQuery.parseJSON(selections1))));
		if(selections2!="")
			$.extend(selections, decodeObject(toObject(jQuery.parseJSON(selections2))));
		if(selections3!="")
			$.extend(selections, decodeObject(toObject(jQuery.parseJSON(selections3))));
		}
		catch(err){
		console.log(err);
		}
		return selections;
	}
	
	function myRound(num, decs){
		var aux=Math.pow(10, decs); 
		return Math.round(num*aux)/aux;
	}
	
	function updateCustomer(customer){
		var customer=siteCache['customer'];
		$(".FreePlayBalance").html(formatnumeric(myRound(customer['FreePlayBalance'], 2), 2, false));
		$(".CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
		$(".AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
		$("#CurrentBalance").html(formatnumeric(myRound(customer['CurrentBalance'], 2), 2, false));
		$("#AvailableBalance").html(formatnumeric(myRound(customer['AvailableBalance'], 2), 2, false));
		$("#AvailablePending").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
		$(".PendingWagerBalance").html(formatnumeric(myRound(customer['PendingWager'], 2), 2, false));
		$(".CasinoBalance").html(formatnumeric(myRound(customer['CasinoBalance'], 2), 2, false));
		$(".CustomerID").html(customer['CustomerID']);
		
		$("#shopping-cart").html(countSelectionsOnBetslip());
	}
	
	function loadYears(){
		var currentTime = new Date()
		var year = currentTime.getFullYear();
		for(var x = year; x < (year + 12); x++){
			$('#cbxExpiryYear').append($('<option>', { 
				value: x,
				text : x 
			}));
		}
	}
	
	function changeAmount(amount) {
		$("#txtDepositAmount").val(amount);
	}
	
	var siteCache = {};
    $(document).ready(function(){
        $('body.lg #userbar, body.md #userbar, body.sm #userbar').remove();
		//$("button[target='#myOffCanvas']").attr("disabled", "disabled").off('click');
		
        $('#navbar li').removeClass('active');
        $('#navbar li:eq(6)').addClass('active');

		siteCache['customer'] = _CUSTOMER_INFO;
        updateCustomer();
		
		loadYears();
		
		$("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");
	
		$(window).resize(function() { 
			$("#divBalance").css("width", ($(window).width() - (53*4)).toString() + "px");
		});
		
		$(".showAccountHistoryReport").parent().css("display","none");
		$(".showSettings").parent().css("display","none");
		
		$("#btnHeaderLeft").click(function(){
			var url = window.location.href.toLowerCase();
			window.location = url.substring(0, url.indexOf("/pages") + 1) + "sportbook";
		});
		
		$("#btnHeaderRight").click(function(){
			var url = window.location.href.toLowerCase();
			window.location = url.substring(0, url.indexOf("/pages") + 1) + "sportbook";
		});
		
		$("#userbar").css("display", "block !important");
		
		$("#txtCreditCard1, #txtCreditCard2, #txtCreditCard3, #txtCreditCard4").keypress(function(e) {
			if($(e.currentTarget).val().length >= 4){
				e.preventDefault();
				//move next
				var inputs = $(this).closest('.rowForm').find(':input');
				inputs.eq(inputs.index(this)+1).blur().focus().val(e.key);
			}
		});
		
		$("#txtCCV").keypress(function(e) {
			if($(e.currentTarget).val().length >= 3) e.preventDefault();
		});
    });
	
	
	  
	function getCurrentSize(){
		var width=window.innerWidth;
	
		if(width>=1200)
			return 'lg';
		else if(width>=992)
			return 'md';
		else if(width>=768)
			return 'sm';
		else
			return 'xs';
	}
	
	function makeAction(){
		// Return today's date and time
		var currentTime = new Date();
		var month = currentTime.getMonth() + 1;
		var year = currentTime.getFullYear();
		
		var deposit = $("#cbxAction").val();
		var methodPayment = $("#cbxMethodPayment").val();
		var depositAmount = $("#txtDepositAmount").val();
		var creditCard = $("#txtCreditCard1").val() + $("#txtCreditCard2").val() + $("#txtCreditCard3").val() + $("#txtCreditCard4").val();
		var expiryMonth = $("#cbxExpiryMonth").val();
		var expiryYear = $("#cbxExpiryYear").val();
		var CCV = $("#txtCCV").val();
		
		var respValid = true;
		var errorMessage = "";
		if ($.trim(depositAmount).length == 0) {
			errorMessage += " - You must enter a valid amount.\n</br>";
			respValid = false;
		}
		
		if ($.trim(creditCard).length == 0 || $.trim(creditCard).length < 16) {
			errorMessage += " - You must enter a valid card number.\n</br>";
			respValid = false;
		}
		
		if (expiryMonth == -1) {
			errorMessage += " - You must enter a valid month.\n</br>";
			respValid = false;
		}
		
		if (expiryYear == -1) {
			errorMessage += " - You must enter a valid year.\n</br>";
			respValid = false;
		}
		
		if (expiryMonth != -1 && expiryYear != -1) {
			if(parseInt((expiryMonth < 10 ? "0" + expiryMonth.toString() : expiryMonth.toString()) + expiryYear.toString()) < parseInt((month < 10 ? "0" + month.toString() : month.toString()) + year.toString())){
				errorMessage += " - You must enter a valid expiry date.\n</br>";
				respValid = false;	
			}
		}
		
		if ($.trim(CCV).length == 0) {
			errorMessage += " - You must enter a valid credit card verification number.\n</br>";
			respValid = false;
		}
		
		if (respValid) {
			//guarda deposito
		}
		else{
			showMessage("BADSAVE", errorMessage, null);
		}
	}
</script>

<style>
	html, body, #container, #content{
        background-color: #212225 !important;
    }
	
	body.xs .navbar-custom.mobile .nav li a .mainMenuLi .mainMenuContent {
		margin-left: calc((100% - 125px)/2);
	}
</style>
<?php } ?>
