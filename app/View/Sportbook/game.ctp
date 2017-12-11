<table class='gameHeader margin-bottom border'>
	<tr class='border-bottom'>
		<td class='backButtonTd border-right'><?php echo $this->element('Sportbook/goBackButton');?></td>
		<td>
			<center>
				<table>
					<tr>
						<td class='imageTd hidden-xs hidden-sm'>
							&nbsp;
							<!--<img class='teamImage' src='/images/team1.gif' alt=''/>-->
						</td>
						<td class='teamsTd teamHome h4'><?php echo __($this->Sportbook->sanitiazeTeamName($game['TeamHomeID']))?></td>
						<td class='versus'><?php echo __('vs')?></td>
						<td class='teamsTd teamAway h4'><?php echo __($this->Sportbook->sanitiazeTeamName($game['TeamAwayID']))?></td>
						<td class='imageTd hidden-xs hidden-sm'>
							&nbsp;
							<!--<img class='teamImage' src='/images/team2.gif' alt=''/>-->
						</td>
					</tr>
				</table>
			</center>
		</td>
	</tr>
	<tr>
		<td colspan="8" class='dateTd'>
			<?php echo $this->Sportbook->formatDay($game['GameDateTime'])?> <?php echo $this->Sportbook->formatTime($game['GameDateTime'])?>
		</td>
	</tr>
</table>

<?php
$hasMainBets=false;
foreach($lines['periods'] as $period)
	if($period['enable']){
		$hasMainBets=true;
		break;
	}
	
if($hasMainBets){
	echo $this->element('Sportbook/print_game_periodTableLong', array("periods"=>$lines['periods'], "game"=>$game));
	echo $this->element('Sportbook/print_game_periodTableShort', array("periods"=>$lines['periods'], "game"=>$game));
}

foreach($props['games'] as $game)
	foreach($game['groups'] as $group)
		echo $this->element('Sportbook/print_game_group', array("groupDescription"=>$group['description'], "bets"=>$group['bets']));


echo $this->element('Sportbook/backToTopButton');
?>
<script>
	$(".groupTitle .openAll").click(function(){
		$(this).siblings(".closeAll").show();
		$(this).hide();
		$(this).parents('.groupTitle').siblings().find(".title.collapsed").each(function(){
			$(this).click();
		});
	});

	$(".groupTitle .closeAll").click(function(){
		$(this).siblings(".openAll").show();
		$(this).hide();
		$(this).parents('.groupTitle').siblings().find(".title:not(.collapsed)").each(function(){
			$(this).click();
		});
	});
</script>
<?php
//echo "<pre>".print_r($props, true)."</pre>";
?>