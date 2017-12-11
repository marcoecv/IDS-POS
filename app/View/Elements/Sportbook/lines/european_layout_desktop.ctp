<?php

$showDrawTitle = false;
    if(sizeof($games) > 0){
        foreach($games as $ga){
            if($ga['draw']['rotNum'] != null){
                $showDrawTitle = true;
                break;
            }
        }        
    }
    
    $sportsWithSpread = array("Basketball","Football","Australian Rules");
    
    $showSpread = $isOverviewButAmericanLayout ? in_array($sportType, $sportsWithSpread) : false; 
    
    $awayTitle = $isOverviewButAmericanLayout ? __("Away") : 2;
    $homeTitle = $isOverviewButAmericanLayout ? __("Home") : 1;
    $drawTitle = $isOverviewButAmericanLayout ? __("Draw") : "X";
    $over = strtoupper(__("Over"));
    $under = strtoupper(__("Under"));
    
    $tinySport = ($sportType == "Soccer" && !$isOverviewButAmericanLayout);
    
    $betContainerSize = $tinySport ? "tiny" : ""; 
    
    
?>
<?php

  $auxDate = '';
  $j=0;
  foreach ($games as $row) {
        $dateWithTimeZone = strtotime ( "+".$timeZoneSeconds." second" , strtotime ( $row['gameHourFormat'] ) ) ;
        $hourTimeZone = date ( 'h:i a' , $dateWithTimeZone );				
        $hour_configured = substr($hourTimeZone, 0, -1);
        ?>
<?php if($j!=0){ ?>
<tbody class='space european-layout-tr'><tr><td colspan='<?= $tinySport ? "13" : "8" ?>'><hr style='margin: 0px;'></td></tr></tbody>
<?php } $j++; ?>

<tbody>
        <?php if (strcmp($auxDate,$row['gameDateFormat']) != 0) {?>
    <tr class="odd" style="height: 8px;">
        <td colspan="2"><span><?php echo __("Date")?>: <?=$row['gameDateFormat2']?></span></td>
        <td><?= $showSpread ? "&nbsp;" : ($showDrawTitle ? $homeTitle : "&nbsp;") ?></td>
        <td><?= $showSpread ? $homeTitle : ($showDrawTitle ? $drawTitle : $homeTitle) ?></td>
        <td><?= $awayTitle ?></td>
                <?php if($tinySport) : ?>
        <td>1X</td>
        <td>12</td>
        <td>2X</td>
                <?php endif; ?>
        <td><?= $over ?></td>
        <td><?= $under ?></td>
                <?php if($tinySport) : ?>
        <td>GG</td>
        <td>NG</td>
                <?php endif; ?>
        <td>&nbsp;</td>
    </tr>
        <?php
                $auxDate = $row['gameDateFormat'];
        }
        ?>
    <!-- THIS NAMES MUST BE HERE BECAUSE THE BETSLIP SCRIPT USE THIS NAME FOR UI -->
    <tr class='away' style="display:none;" gamenum='<?php echo $row['gameNum']?>'>
        <td>
            <div class='teamName'><?php echo (substr($row['awayTeam']['teamName'], 0, 1) == "." ? substr($row['awayTeam']['teamName'], 1) : $row['awayTeam']['teamName']) ?></div>
        </td>
    </tr>
    <tr class='home'  style="display:none;" gamenum='<?php echo $row['gameNum']?>'>
        <td>
            <div class='teamName'><?php echo (substr($row['homeTeam']['teamName'], 0, 1) == "." ? substr($row['homeTeam']['teamName'], 1) : $row['homeTeam']['teamName']) ?></div>
        </td>
    </tr>
    <!-- ----------------------------------------------------------------------- -->

    <tr class='<?php  echo $row['gameNum']?>' gamenum='<?php echo $row['gameNum']?>' >
        <td class='border-right gameDate' rowspan='3'  <?php echo $isUpcoming ? "minutes='".$row["minutesUntilStart"]."'" : ""; ?>>
            <span class="date-span"><?php  echo $hour_configured?></span><br/>
        </td>

        <td class='border-bottom teamInfo european-layout-teamInfo'>
            <div class='teamName'><small><?= $isOverviewButAmericanLayout ? "" : 1 ?> </small> <?php 
                        echo $isOverviewButAmericanLayout ? 
                                (substr($row['awayTeam']['teamName'], 0, 1) == "." ? substr($row['awayTeam']['teamName'], 1) : $row['awayTeam']['teamName'])
                                : 
                                (substr($row['homeTeam']['teamName'], 0, 1) == "." ? substr($row['homeTeam']['teamName'], 1) : $row['homeTeam']['teamName']) ?>                    
            </div><br>
            <div class='teamName'><small><?= $isOverviewButAmericanLayout ? "" : 2 ?> </small> <?php 
                        echo $isOverviewButAmericanLayout ?
                                (substr($row['homeTeam']['teamName'], 0, 1) == "." ? substr($row['homeTeam']['teamName'], 1) : $row['homeTeam']['teamName'])
                                :
                                (substr($row['awayTeam']['teamName'], 0, 1) == "." ? substr($row['awayTeam']['teamName'], 1) : $row['awayTeam']['teamName']) ?></div>                    
        </td>

        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                    <?php if($showDrawTitle && !$showSpread){ ?>
                        <?php if ($row['homeTeam']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['moneyLine']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['moneyLine']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['moneyLine']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['moneyLine']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['homeTeam']['moneyLine']['selectorId']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['moneyLine']['americanPrice'];
                              else
                                    echo $row['homeTeam']['moneyLine']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php } ?>
                    <?php } ?>
        </td>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                    <?php if(!$showDrawTitle || $showSpread){ 
                        if(!$showSpread) { ?>
                        <?php if ($row['homeTeam']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['moneyLine']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['moneyLine']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['moneyLine']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['moneyLine']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['homeTeam']['moneyLine']['selectorId']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['moneyLine']['americanPrice'];
                              else
                                    echo $row['homeTeam']['moneyLine']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php } ?>
                    <?php 
                        }else{ ?>
                            <?php if ($row['homeTeam']['spread']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['spread']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['spread']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['spread']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['spread']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['homeTeam']['spread']['thresholdSF']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['homeTeam']['spread']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><strong><?php echo $row['homeTeam']['spread']['threshold']?></strong></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['spread']['americanPrice'];
                              else
                                    echo $row['homeTeam']['spread']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                               <?php }?>

                        <?php }
                        }else{ ?>
                        <?php if ($row['draw']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary($row['draw']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription']))?>"
                    betDescription="<?php echo __($this->App->dictionary($row['draw']['moneyLine']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['draw']['moneyLine']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['draw']['moneyLine']['decimalPrice']?>"
                    us = "<?php echo $row['draw']['moneyLine']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?=$row['draw']['moneyLine']['selectorId']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['draw']['moneyLine']['americanPrice'];
                               else
                                 echo $row['draw']['moneyLine']['decimalPrice'];

                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
                    <?php } ?>
        </td>    
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                    <?php if($showSpread){ ?>
                        <?php if ($row['awayTeam']['spread']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"								
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['awayTeam']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['awayTeam']['spread']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['awayTeam']['spread']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['awayTeam']['spread']['decimalPrice']?>"
                    us = "<?php echo $row['awayTeam']['spread']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['awayTeam']['spread']['thresholdSF']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['awayTeam']['spread']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><strong><?php echo $row['awayTeam']['spread']['threshold']?></strong></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['awayTeam']['spread']['americanPrice'];
                              else
                                    echo $row['awayTeam']['spread']['decimalPrice'];
                     ?>								
                    </div>
                </div>
            </button>
                                <?php }?>
                    <?php }else{ ?>
                        <?php if ($row['awayTeam']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['awayTeam']['teamName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['awayTeam']['moneyLine']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['awayTeam']['moneyLine']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['awayTeam']['moneyLine']['decimalPrice']?>"
                    us = "<?php echo $row['awayTeam']['moneyLine']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['awayTeam']['moneyLine']['selectorId']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['awayTeam']['moneyLine']['americanPrice'];
                              else
                                    echo $row['awayTeam']['moneyLine']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>                          
                    <?php } ?>
        </td>
                <?php if($tinySport): ?>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                        <?php if (isset($row['homeTeam']['doubleChanceProp']) && $row['homeTeam']['doubleChanceProp']['one_x']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary(str_replace("Draw", __("Draw"),  $row['homeTeam']['doubleChanceProp']['one_x']['contestantName']))) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($sportSubType." Props")) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['doubleChanceProp']['contestDescription'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['doubleChanceProp']['one_x']['betTypeis']?>"
                    mainBet="0"
                    dec = "<?php echo $row['homeTeam']['doubleChanceProp']['one_x']['decimalOdds']?>"
                    us = "<?php echo $row['homeTeam']['doubleChanceProp']['one_x']['moneyLineSF']?>"
                    contestnum="<?= $row['homeTeam']['doubleChanceProp']['contestNum'] ?>" 
                    contestantnum="<?= $row['homeTeam']['doubleChanceProp']['one_x']['contestantNum'] ?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['gameNum']."_".$row['homeTeam']['doubleChanceProp']['contestNum']."_".$row['homeTeam']['doubleChanceProp']['one_x']['contestantNum']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['doubleChanceProp']['one_x']['moneyLine'];
                              else
                                    echo $row['homeTeam']['doubleChanceProp']['one_x']['decimalOdds'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>  
        </td>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                        <?php if (isset($row['homeTeam']['doubleChanceProp']) && $row['homeTeam']['doubleChanceProp']['one_two']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['doubleChanceProp']['one_two']['contestantName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($sportSubType." Props")) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['doubleChanceProp']['contestDescription'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['doubleChanceProp']['one_two']['betTypeis']?>"
                    mainBet="0"
                    dec = "<?php echo $row['homeTeam']['doubleChanceProp']['one_two']['decimalOdds']?>"
                    us = "<?php echo $row['homeTeam']['doubleChanceProp']['one_two']['moneyLineSF']?>"
                    contestnum="<?= $row['homeTeam']['doubleChanceProp']['contestNum'] ?>" 
                    contestantnum="<?= $row['homeTeam']['doubleChanceProp']['one_two']['contestantNum'] ?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['gameNum']."_".$row['homeTeam']['doubleChanceProp']['contestNum']."_".$row['homeTeam']['doubleChanceProp']['one_two']['contestantNum']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['doubleChanceProp']['one_two']['moneyLine'];
                              else
                                    echo $row['homeTeam']['doubleChanceProp']['one_two']['decimalOdds'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>  
        </td>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                       <?php if (isset($row['homeTeam']['doubleChanceProp']) && $row['homeTeam']['doubleChanceProp']['x_two']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary(str_replace("Draw", __("Draw"),  $row['homeTeam']['doubleChanceProp']['x_two']['contestantName']))) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($sportSubType." Props")) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['doubleChanceProp']['contestDescription'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['doubleChanceProp']['x_two']['betTypeis']?>"
                    mainBet="0"
                    dec = "<?php echo $row['homeTeam']['doubleChanceProp']['x_two']['decimalOdds']?>"
                    us = "<?php echo $row['homeTeam']['doubleChanceProp']['x_two']['moneyLineSF']?>"
                    contestnum="<?= $row['homeTeam']['doubleChanceProp']['contestNum'] ?>" 
                    contestantnum="<?= $row['homeTeam']['doubleChanceProp']['x_two']['contestantNum'] ?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['gameNum']."_".$row['homeTeam']['doubleChanceProp']['contestNum']."_".$row['homeTeam']['doubleChanceProp']['x_two']['contestantNum']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['doubleChanceProp']['x_two']['moneyLine'];
                              else
                                    echo $row['homeTeam']['doubleChanceProp']['x_two']['decimalOdds'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
                <?php endif; ?>
        <td class='border-bottom selectionWrap total <?= $betContainerSize ?>'>
                        <?php if ($row['awayTeam']['total']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary($row['awayTeam']['total']['totalPointsOUDesc'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['awayTeam']['total']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['awayTeam']['total']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['awayTeam']['total']['decimalPrice']?>"
                    us = "<?php echo $row['awayTeam']['total']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['awayTeam']['total']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['awayTeam']['total']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['awayTeam']['total']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><strong><?php echo str_replace("O", "", $row['awayTeam']['total']['totalPointsOU'])?><?php echo $row['awayTeam']['total']['threshold']?></strong></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['awayTeam']['total']['americanPrice'];
                              else
                                    echo $row['awayTeam']['total']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
        <td class='border-bottom selectionWrap total <?= $betContainerSize ?>'>
                        <?php if ($row['homeTeam']['total']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"                                        
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo __($this->App->dictionary($row['homeTeam']['total']['totalPointsOUDesc'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['total']['betTypeDesc'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['total']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['total']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['total']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['homeTeam']['total']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['homeTeam']['total']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "<?php  echo $row['isParlay']?>"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "<?php  echo $row['isTeaser']?>"
                    selectionid="<?php echo $row['homeTeam']['total']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><strong><?php echo str_replace("U", "", $row['homeTeam']['total']['totalPointsOU']) ?><?php echo $row['homeTeam']['total']['threshold']?> </strong></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['total']['americanPrice'];
                              else
                                    echo $row['homeTeam']['total']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
                <?php if($tinySport): ?>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                        <?php if (isset($row['homeTeam']['goalNoGoalProp']) && $row['homeTeam']['goalNoGoalProp']['GG']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['goalNoGoalProp']['GG']['contestantName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($sportSubType." Props")) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['goalNoGoalProp']['contestDescription'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['goalNoGoalProp']['GG']['betTypeis']?>"
                    mainBet="0"
                    dec = "<?php echo $row['homeTeam']['goalNoGoalProp']['GG']['decimalOdds']?>"
                    us = "<?php echo $row['homeTeam']['goalNoGoalProp']['GG']['moneyLineSF']?>"
                    contestnum="<?= $row['homeTeam']['goalNoGoalProp']['contestNum'] ?>" 
                    contestantnum="<?= $row['homeTeam']['goalNoGoalProp']['GG']['contestantNum'] ?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['gameNum']."_".$row['homeTeam']['goalNoGoalProp']['contestNum']."_".$row['homeTeam']['goalNoGoalProp']['GG']['contestantNum']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['goalNoGoalProp']['GG']['moneyLine'];
                              else
                                    echo $row['homeTeam']['goalNoGoalProp']['GG']['decimalOdds'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
        <td class='border-bottom selectionWrap moneyLine <?= $betContainerSize ?>'>
                        <?php if (isset($row['homeTeam']['goalNoGoalProp']) && $row['homeTeam']['goalNoGoalProp']['NG']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    chosenTeamID="<?php echo __($this->App->dictionary( $row['homeTeam']['goalNoGoalProp']['NG']['contestantName'])) ?>"
                    groupDescription="<?php echo __($this->App->dictionary($sportSubType." Props")) ?>"
                    betDescription="<?php echo __($this->App->dictionary($row['homeTeam']['goalNoGoalProp']['contestDescription'])) ?>"
                    betTypeis = "<?php echo  $row['homeTeam']['goalNoGoalProp']['NG']['betTypeis']?>"
                    mainBet="0"
                    dec = "<?php echo $row['homeTeam']['goalNoGoalProp']['NG']['decimalOdds']?>"
                    us = "<?php echo $row['homeTeam']['goalNoGoalProp']['NG']['moneyLineSF']?>"
                    contestnum="<?= $row['homeTeam']['goalNoGoalProp']['contestNum'] ?>" 
                    contestantnum="<?= $row['homeTeam']['goalNoGoalProp']['NG']['contestantNum'] ?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['gameNum']."_".$row['homeTeam']['goalNoGoalProp']['contestNum']."_".$row['homeTeam']['goalNoGoalProp']['NG']['contestantNum']?>">
                <div class="row">
                    <div class="odds col-xs-12">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['goalNoGoalProp']['NG']['moneyLine'];
                              else
                                    echo $row['homeTeam']['goalNoGoalProp']['NG']['decimalOdds'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
                <?php endif; ?>
        <td id='linkSelectGame_<?php echo $row['gameNum']?>' style='width: 60px; background-color: #2f3c42;border-radius: 4px' rowspan='3'>
            <div class='link selectGame' GameNum='<?php echo $row['gameNum']?>' >
                <div class='link selectGame outer' GameNum='<?php echo $row['gameNum']?>' >
                    <div class='inner'>
                        <div class='counter' style="text-align: center; line-height: 45px">
                            <span><?php echo (intval($row['countMarkets']) > 0) ? ($row['countMarkets'] - $countMarketsToRest) : ""?></span>&nbsp;&nbsp;
                            <i class='icon-caret'></i>
                        </div>
                    </div>
                </div>
            </div>
        </td>               
    </tr>
</tbody>
  <?php  }?>
<tbody class="space european-layout-tr border-bottom"><tr class="odd"><td colspan="<?= $tinySport ? "13" : "8" ?>"></td></tr></tbody>
<tbody class="space european-layout-tr"><tr class="odd"><td colspan="<?= $tinySport ? "13" : "8" ?>"></td></tr></tbody>

