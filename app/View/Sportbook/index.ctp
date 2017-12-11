<?php
function printGameTr($sportType, $home, $away, $date, $time, $odd){
	?>
	<tr class='<?php echo $odd?>'>
		<td rowspan='2' class='iconSportWrap border-bottom border-right'><div class='iconSport <?php echo $sportType?>'></div></td>
		<td class='team border-bottom '><?php echo $home?></td>
		<td rowspan='2' class='gameDate border-bottom border-left'>
			<?php echo $date?><br/>
			<?php echo $time?>
		</td>
	</tr>
	<tr class='<?php echo $odd?>'>
		<td class='team border-bottom'><?php echo $away?></td>
	</tr>
	<?php
}
?>
<center class='mainBanner'>
    <img src='/images/banner.png'>
</center>
<table class="table-games upcomming">
    <caption><?php echo __('Upcoming Live');?></caption>
    <tbody>
		<?php printGameTr("basketball", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', 'odd')?>
		<?php printGameTr("basketball", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', '')?>
		<?php printGameTr("soccer", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', 'odd')?>
		<?php printGameTr("soccer", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', '')?>
		<?php printGameTr("baseball", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', 'odd')?>
		<?php printGameTr("hockey", "robert morris colonials", "north florida ospreys", 'Thu 3/5', '3:00pm', '')?>
    </tbody>
</table>
