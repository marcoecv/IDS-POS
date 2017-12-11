<?php
    $periodSelectedClass = '';
    $periodDescription = '';
    $style = 'float:left; margin-right: 3px;';
?>

<div id="sliderID" class='subGroupSelector col-lg-12 col-md-12 col-sm-12 col-xs-12' style='width: 100%;'>
    <?php    
    $sizePeriodBtn = 0;
    if (count($periods) == 7){
        $sizePeriodBtn = 1;
    }else{
        $sizePeriodBtn = (12*(100/count($periods)))/100; 
    }
    
   
    foreach ($periods as $row) {?>
    <div class='wrapButton col-lg-<?=$sizePeriodBtn?> col-md-<?=$sizePeriodBtn?> col-sm-<?=$sizePeriodBtn?> col-xs-<?=$sizePeriodBtn?>' style="height:40px;">
        <?php if ($row['PeriodNumber']==$periodSelected)
                $periodSelectedClass = 'btn-success';
            else
                $periodSelectedClass = '';
        ?>
        <button class='btn btn-primary btn-sm btn-md toggle-container <?=$groupId?> <?=$periodSelectedClass?>' style="width: 100%; height:40px;" data-textXs="1QLH" type='button'
                group = "<?=$groupId?>"
                data-period='period_<?=$groupId?>_<?=$row['PeriodNumber']?>'
                periodNumber="<?php echo $row['PeriodNumber']?>"
				scheduleText = "<?php echo $scheduleText?>"
                sportType= "<?php echo $sportType?>"
				sportSubType= "<?php echo $sportSubType?>">
            <span class='long-period-name hidden-xs'><?=$row['PeriodDescription']?></span><span class='short-period-name visible-xs'><?=$periodsDescShort[$row['PeriodNumber']]?></span>
        </button>
    </div>
    <?php }?>
</div>