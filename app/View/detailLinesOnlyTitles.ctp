<?php $groupIdPadre = strtolower('group_'.$params['sports']."_".$params['leagues']); ?>
<div id="<?php echo $groupIdPadre?>" order="<?php echo $sportsOrder?>">
<?php
    $groupId ='';
    $title= '';
    $order = 0;

  foreach($schedules as $category){
	
	$order = $order + 1;
     $groupId =  $this->App->sanitiazeId(strtolower('group_'.$params['sports']."_".$params['leagues']."_".$category));
     $title= $params['sports']." - ".$params['leagues']." - ".$category;
    
     $params['scheduleText']=$category;
     $params['groupIdParent']=$groupIdPadre;
     $params['groupIdChild']=$groupId;
	$params['order']=$order;
    
     $arrayJS= json_encode($params);
     
?>

    <div class='group' id="<?php echo $groupId?>" onclick='loadSelectedLines(<?php echo $arrayJS?>);' >
        <div class='title collapsed' data-toggle='collapse' href="#body_<?php echo $groupId?>" aria-expanded="false"><?=$title?>
            <div class='toggle-icon'></div>
        </div>
    </div>
<?php } ?>
</div>


