<?php
    $arrayPeriods = array(
        "periods" => $periods,
        "periodsDescShort" => $periodsDescShort,
        "periodSelected" => $periodSelected,
        "groupId" => $groupId,
        "sizeBody" => $sizeBody,
        "sportType" => $sportType,
        "sportSubType" => $sportSubType,
        "scheduleText" => $scheduleText,
        "isFavorite" => $isFavorite,
        "isOverview" => $isOverview,
        "gamenumsForPeriods" => $gamenumsForPeriods,
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
        "timeZone" => $timeZone,
        "isOverview" => $isOverview,
        "overview_layout" => $overview_layout,
        "isOverviewButAmericanLayout" => $isOverviewButAmericanLayout,
        "isUpcoming" => $isUpcoming,
    );
    
    $classSliderWrap = "sliderWrap";

    
?>

<?php if (!$update){ ?>

<div class='group <?= $isFavorite ? "favorite" : "" ?> <?= $isOverview  ? "overview-game" : "" ?>' id="<?php echo $groupId?>">

<?php } ?>
    <div class='title' href="#body_<?php echo $groupId?>">
        <div class='glyphicon glyphicon-remove removeFromLines iconDeleteLeague' league="<?php echo $groupId?>" idParent="<?php echo $groupIdPadre?>"></div>
        <div class='titleLeague' data-toggle='collapse' href="#body_<?php echo $groupId?>">       
            <?php echo ($isUpcoming && $periodSelected != 2) ? __("Upcoming")." " : "" ?><?=__($this->App->dictionary(($title)))?><?= ($periodSelected == 2 && $isUpcoming) ? " - ".__("2ND HALF LINES") : "" ?>
            <div class='toggle-icon'></div>
         </div>      
    </div>
    <div id="body_<?php echo $groupId?>" class='in margin-bottom'>
        <?php if(!$isOverview) : ?>
        <div class='<?php echo $classSliderWrap?>'>
           <?php echo $this->element('Sportbook/periods', $arrayPeriods);?>  
        </div>
        <?php        endif; ?>
        <div class='periods'>
           <?php echo $this->element('Sportbook/games', $arrayGames);?>   
        </div>
    </div>
<?php if (!$update){?>
</div>
<?php } ?>
