<?
    $arrayPeriods = array(
        "periods" => $periods,
        "periodsDescShort" => $periodsDescShort,
        "periodSelected" => $periodSelected,
        "groupId" => $groupId,
        "sizeBody" => $sizeBody,
        "sportType" => $sportType,
        "sportSubType" => $sportSubType,
        "scheduleText" => $scheduleText
    );
    $arrayGames = array(
        "games" => $games,
        "groupId" => $groupId,
        "periodSelected" => $periodSelected,
        "scheduleText" => $scheduleText,
        "sizeBody" => $sizeBody,
        "sportType" => $sportType,
        "sportSubType" => $sportSubType,
        "formatPriceAmerican" => $formatPriceAmerican,
        "timeZone" => $timeZone
    );
    
    $classSliderWrap = "sliderWrap";
    
?>

<div class='group' id="<?=$groupId?>" >
    <div class='title' data-toggle='collapse' href="#body_<?=$groupId?>"><?=$title?>
        <div class='toggle-icon'></div>
    </div>
    <div id="body_<?=$groupId?>" class='in margin-bottom'>
        <div class='<?=$classSliderWrap?>'>
           <?= $this->element('Sportbook/periods', $arrayPeriods);?>  
        </div>
        <div class='periods'>
           <?= $this->element('Sportbook/games', $arrayGames);?>   
        </div>
    </div>
</div>
