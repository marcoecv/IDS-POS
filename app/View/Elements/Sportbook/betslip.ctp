<?php
	$urlCur = Router::url($this->here, true);
	$urlCur = strtolower($urlCur);
	$protocol = substr($urlCur, 0, stripos($urlCur, "//") + 2);
	$urlCur = str_replace($protocol, "", $urlCur);
	$urlCur = substr($urlCur, stripos($urlCur, "/") + 1);
	$params = explode("/", $urlCur);
	//$urlCur = $protocol.$urlCur;
?>

<div id='betslip'>
	<div class="panel panel-default">
        <div class="panel-heading pannel-heading-1" >
            <div class="panel-title"><center><b>Disponible:</b> <span id="betBalance"> <?php echo round($fullCustomer['Available'],2) ?></span></center></div>
            <input type="hidden" id="sp_CustomerID" value="<?=$fullCustomer["CustomerID"]?>"/>
            <input type="hidden" id="sp_AuthCustomerID" value="<?=$authCustomerID?>"/>
        </div>
        <div class="panel-body" id="betslipPanelBody">
			<div style="float: right;">
			</div>
			<div style="clear:both;"></div>
			
			<div class="betslipTypeSelector margin-bottom" id="divSelectorButton">
				<?php
					
					$countBetTypes = sizeof($betTypes);
					$pos = 0;
					$cell = 4;
					$cellCount = 0;
					
					echo "<table class='row' style='width:100%'><tr>";
					foreach ($betTypes as &$betType) {
						
						$cell = 4;
//						if($pos == 0){
//							$cell = 12;
//						}
						
						if (($pos == 1 && $countBetTypes == 2) || ($pos == 1 && $countBetTypes == 3) || ($pos == 2 && $countBetTypes == 3) || ($countBetTypes == 2 && $pos == 0)){
							$cell = 6;
						}
						
						echo "<td style='width:33%' class='optionWrap'><button style='height:40px;width:100%' class='btn btn-info option ".strtolower($betType)."' select='".strtolower($betType)."'>".__($betType)."</button></td>";
						
//						$cellCount = $cellCount + $cell;
						
//						if($cellCount == 12){
//							echo "</div>";
//							echo "<div class='row'>";
//							$cellCount = 0;
//						}
//						
//						$pos++;
					}
					echo "</tr></table>";
				?>
				<!--div class='col-xs-4 optionWrap'><div class='option actionPoints' select="actionPoints"><?php //echo __('Action Pts.');?></div></div-->
			</div>
                        <div id='placeBetWrap'>
                            <button class="btn btn-continue btn-sm" id='placeBet' data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> PlaceBet" type="button"> CREAR TIQUETE</button>
                            <!--<div class="progress secret" id='placebetBar'>
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                            </div>-->
                        </div>
			<div>
				<div class="visible-xs-block" style="padding-right: 2px;width: 106px; float: left;">
					<button id="btnCloseBetSlip" class="btn btn-danger toggle-myOffCanvas" side="right" target="#myOffCanvas" type="button"><?php echo __('Back');?></button>
				</div>
				<div class="betslipTypeSelector" id="divSelectorSelect" style="float: left;width: calc(100% - 106px);">
					<div class='row'>
						<div class='col-xs-12 selectorWrap'>
							<div tabindex="1" class="wrapper-dropdown-5" id="cbmBetType"><span id='opSelectedetType'><?php echo __(trim(array_values($betTypes)[0])." Bet");?></span>
								<ul class="dropdown">
									<?php
										$pos = 0;
										foreach ($betTypes as &$betType) {
											echo "<li><a href='#' data-val='".strtolower($betType)."'>".__($betType.($pos == 0 ? " Bet" : ""))."</a></li>";
											$pos++;
										}
									?>
								</ul> 
							</div>
						</div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<hr style='margin-top: 5px;margin-bottom: 5px;'/>
			<div class='allAmountMenu margin-bottom secret'>
				<!--<div class='table'>
					<div class='cell'>Risk: <input type='number' pattern='[0-9]*' inputmode='numeric' name='risk' value='' class='amount riskAmount' placeholder="ALL"/></div>
					<div class='cell'>Win: <input type='number' pattern='[0-9]*' inputmode='numeric' name='win' value='' class='amount winAmount' placeholder="ALL"/></div>
					<div class='cell'>Bet: <input type='number' pattern='[0-9]*' inputmode='numeric' name='win' value='' class='amount betAmount' placeholder="ALL"/></div>
				</div>-->
				
				<div class='table' style="float:left; max-width:100%;">
                                    <?php 
                                    foreach ($betConfig as $value) {
                                        $defaultSelec="";
                                        if($formatDisplay=="American" && $value=="Bet"||$formatDisplay=="European" && $value=="Risk"){
                                            $defaultSelec="btn-success";
                                        }
                                    ?>
                                    <div class='cell' style="width: 100px;">
                                        <button class="btn btn-primary btn-sm toggle-container <?=$defaultSelec?>"  onclick="changeGenTypeBet(this)" type="button" target="#txtBet"><?php echo __($value);?></button>
                                    </div>
                                    <?php
                                    }
                                    ?>
				</div>
				<div class='table' id="divTxtAmountGeneral" style="float:left; max-width:100%;">
					<div class='cell'>
						<input type='number' pattern='[0-9]*' inputmode='numeric' name='bet' id='txtBet' value='' class='amount betAmount' placeholder="<?php echo __('Bet Amount');?>" />
					</div>
					<div class='cell'>
                                            <input type='number' pattern='[0-9]*' inputmode='numeric' name='risk' id='txtRisk' value='' class='amount riskAmount' placeholder="<?php echo __('Risk Amount');?>"  style="display:none;" />
					</div>
					<div class='cell'>
						<input type='number' pattern='[0-9]*' inputmode='numeric' name='win' id='txtWin' value='' class='amount winAmount' placeholder="<?php echo __('Win Amount');?>" style="display:none;" />
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div class='teaserAmounts margin-bottom secret'>
				<div class='maxRiskWrap'>
					<label class="maxRiskLabel" style="width:30%;"><?php echo __('Risk');?>:</label>
                                        <input id="teaserRiskAmount" type='number' pattern="[0-9]*" inputmode="numeric" name='risk' value='' class='teaserRiskAmount amount' style="float: right;text-align: right;width: 65%" />
				</div>
				<div class='maxToWinWrap'>
					<label class="maxToWinLabel" style="width:30%;"><?php echo __('Win');?>:</label>
                                        <input id="teaserWinAmount" type='number' pattern="[0-9]*" inputmode="numeric" name='win' value='' class='teaserWinAmount amount' style="float: right;text-align: right;width: 65%"/>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div class='globalAmount margin-bottom secret'>
				<div class='riskAmountWrap'>
					<div class='col-xs-12'>
                                            <label><?php echo __('Amount');?>:&nbsp;</label><input type='number' pattern="[0-9]*" inputmode="numeric" name='risk' value='txtContinueOnPushFlag' class='riskAmount amount' onkeyup="txtRiskChange(this)" onchange="txtRiskChange(this)" id="riskAmount" />
					</div>
					<div class='globalFreePlayWrap secret col-xs-6'>
						FP<input type='checkbox' name='globalFreePlay' class='globalFreePlay' value='1'/>
						<script>
							$('#betslip .globalFreePlay').checkbox({
								buttonStyle: 'btn-base',
								buttonStyleChecked: 'btn-success',
								checkedClass: 'icon-check',
								uncheckedClass: 'icon-check-empty'
							});
						</script>
					</div>
				</div>
			</div>
			<div class='reverseAmountWrap margin-bottom secret'>
				<label><?php echo __('Amount');?>:&nbsp;</label>
                                <input type='number' pattern="[0-9]*" inputmode="numeric" name='risk' value='' class='reverseAmount amount'/>
			</div>
			
                        <div class='selections sort' style="width: 290px;"></div>
			<div class='emptyBetslip secret margin-bottom' id="divMsgBetslipEmpty"><?php echo __('Your betslip is empty');?></div>
			<div class='panel panel-default margin-bottom globalMessages secret'>
				<div class='panel-body messages'>
					<div class='message lowBalanceError secret'>
						<span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
						<?php echo __('Not enough available balance');?>
					</div>
					<div class='message lowFreePlayError'>
						<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> 
						<?php echo __('Not enough free play');?>
					</div>
					<div class='message amountError'>
						<span class='glyphicon glyphicon-usd' aria-hidden='true'></span> 
						<?php echo __('Please verify selections amounts');?>
					</div>
					<div class='message restWagerError'>
						<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> 
						<?php echo __('You are not allowed to bet this side of the game.');?>
					</div>
					<div class='message unavailableError'>
						<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> 
						<?php echo __('Please remove unavailable selections');?>
					</div>
					<div class='message changeSelectionError'>
						<span class='glyphicon glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> 
						<?php echo __('One or more selections changed');?>
					</div>
					<div class='message maxSelectionAllowedError'>
						<span class='glyphicon glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> 
						<?php echo __('You have exceeded the max amount of');?> <span class='maxSelectionsAllowed'></span> <?php echo __('selections');?>
					</div>
					<div class='message minSelectionAllowedError'>
						<span class='glyphicon glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> 
						<?php echo __('You need at least');?> <span class='minSelectionsAllowed'></span> <?php echo __('selections on your betslip');?>
					</div>
					<div class='message illegalSelectionBetTypeError'>
						<span class='glyphicon glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> 
						<?php echo __('You have selections that can not be placed in the current bet type');?>
					</div>
					<div class='message illegalHookupCombinationErrors'>
						<span class='glyphicon glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> 
						<?php echo __('You have selections that can not be combined in the current bet type');?>
					</div>
					<div class='message openBetDenyError'>
						<span class='glyphicon glyphicon glyphicon-ban-circle' aria-hidden='true'></span> 
						<?php echo __('The current bet type does not allow open selections');?>
					</div>
					<div class='message lowLimitError secret'>
						<span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
						<?php echo __('Bet amount has to be over');?> <span class='amount'></span>.
					</div>
					<div class='message highLimitError secret'>
						<span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
						<?php echo __('Bet amount has to be under');?> <span class='amount'></span>.
						<br/>(<?php echo __('Bet');?>:<span class='betedAmount'></span>/<span class='total'></span>)
					</div>
				</div>
			</div>
			<div class='panel panel-default margin-bottom serverMessages secret'>
				<div class='panel-body messages'></div>
			</div>
			
			<!--div id='addOpenBetWrap' class='secretx margin-bottom'>
				<button class="btn btn-primary btn-sm addOpenSelectionToBetslip" id='addOpenBet' type="button"><?php echo __('Add Open Selection');?></button>
			</div-->
			<div id='teaserSelectorWrap' class='panel panel-default'>
				<div class='panel-body'>
					<center>
						<div id='currentTeaserType'></div>
						<button class="btn btn-success btn-sm" id='openTeaserSelector' type="button"><?php echo __('Select Teaser');?></button>
					</center>
				</div>
			</div>
			<div id='roundRobinSelectorWrap' class='margin-bottom'>
				<?php
					//print_r($parlayInfo['parlayDetails']);
					$maxGamesParlays=array();
					foreach($parlayInfo['parlayDetails'] as $parlayDetail)
						$maxGamesParlays[]=floatval($parlayDetail['GamesPicked']);
					sort($maxGamesParlays);
					
					$lists=array();
					$list=array();
					foreach($maxGamesParlays as $maxGamesParlay){
						$list[]=$maxGamesParlay;
						$lists[]=$list;
					}
				?>
				<select name='roundRobinType' id='roundRobinType'>
					<?php
					foreach($lists as $list){
						$value="";
						$label="By ";
						$coma=false;
						foreach($list as $n){
							$label.=$coma!=""? ",{$n}'s":"{$n}'s";
							$value=$n;
							$coma=true;
						}
						?>
						<option value='<?php echo $value?>'><?php echo $label?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div id='ContinueOnPushFlagWrapIfBet' class='margin-bottom'>
				<select name='ContinueOnPushFlag' class='ContinueOnPushFlag'>
					<option value='N'><?php echo __('IF WIN ONLY');?></option>
					<option value='Y'><?php echo __('IF WIN/PUSH');?></option>
				</select>
			</div>
			<div id='ContinueOnPushFlagWrapReverse' class='margin-bottom'>
				<select name='ContinueOnPushFlag' class='ContinueOnPushFlag' readonly="readonly" disabled="disabled" style="visibility: hidden; display: none;">
					<!--<option value='N'>WIN ONLY REVERSE</option>-->
					<option value='Y'><?php echo __('ACTION REVERSE');?></option>
				</select>
				<input type="text" value="ACTION REVERSE" id="txtContinueOnPushFlag" readonly="readonly" >
			</div>
			
			
			
			<div class='maxAmounts secret'>
				<div class='maxRiskWrap'>
					<label class="maxRiskLabel"><?php echo __('Max Risk');?>:</label>
					<label class="maxRisk" style="margin-left: 5px;"></label>
				</div>
				<div style="clear: both;"></div>
				<div class='maxToWinWrap'>
					<label class="maxToWinLabel"><?php echo __('Max Win');?>: </label>
					<label class="maxToWin" style="margin-left: 5px;"></label>
				</div>
				<div style="clear: both;"></div>
                                <?php
                                if($formatDisplay=="European"){
                                ?>
                                <div class='cuotaWrap'>
                                    <label class="cuotaLabel"><?php echo __('Cuota');?>: </label>
                                    <label class="cuotaValue" style="margin-left: 5px;"></label>
                               </div>
                                <?php }?>
                                <div style="clear: both;"></div>
			</div>
			
			
			
			<div id='acceptChangesWrap' class='secret'>
				<button class="btn btn-success btn-sm" id='acceptChanges' type="button"><?php echo __('Accept All Changes');?></button>
			</div>
			<!--div id='placeBetWrapFull' class='margin-top'>
				<button class="btn btn-danger btn-sm" id='placeBetFull' type="button">Place Bet Hacker</button>
				<div class="progress secret" id='placebetBarFull'>
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
				</div>
			</div-->
    	</div>
    </div>
</div>
<script>
	$("input#txtContinueOnPushFlag").on({
		keydown: function(e) {
		  if (e.which === 32 || e.which === 8)
			return false;
		},
		change: function() {
		  this.value = this.value.replace(/\s/g, "");
		}
	  });
</script>