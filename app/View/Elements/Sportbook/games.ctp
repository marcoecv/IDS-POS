<?php 
    $timeZoneSeconds = $this->App->get_timezone_offset('America/New_York',$timeZone); 
   
    $arrayGames = array(
        "games" => $games,
        "groupId" => $groupId,
        "periodSelected" => $periodSelected,
        "scheduleText" => $scheduleText,
        "sizeBody" => $sizeBody,
        "sportType" => $sportType,
        "sportSubType" => $sportSubType,
        "formatPriceAmerican" => $formatPriceAmerican,
        "timeZone" => $timeZone,
        "isOverview" => $isOverview,
        "timeZoneSeconds" => $timeZoneSeconds,
        "isOverviewButAmericanLayout" => $isOverviewButAmericanLayout,
        "isUpcoming" => $isUpcoming
    );
?>
<div class='margin-bottom period' id='betID' schedule='<?php echo $scheduleText?>' sport='<?php echo $sportType?>' period='<?php echo $periodSelected?>' league='<?php echo $sportSubType?>'>
	
	<!-- Deskop -->
	
	<div id='groupPeriodDesktop' class='sort hidden-xs'>
		<table class='table-games sort'>
                    <?php 
                        if($overview_layout == "american"){
                            echo $this->element('Sportbook/lines/american_layout_desktop',$arrayGames);
                        }else{
                            echo $this->element('Sportbook/lines/european_layout_desktop',$arrayGames);
                        } 
                    ?>
		</table>            
	</div>
	
	<!-- fin Deskop -->
	
</div>
