<?php
    $showDrawTitle = false;
    if(sizeof($games) > 0){
        if($games[0]['draw']['rotNum'] != null){
            $showDrawTitle = true;
        }
    }
        
    $awayTitle = 2;
    $homeTitle = 1;
    $drawTitle = "X";
    $over = __("Over");
    $under = __("Under");
?>
<div class="betType">
        <table id="tableHeaderButton">
                <tbody>
                        <tr class="">
                                <td class="selectionWrap">
                                        <div class="betTypeSelector">                                                
                                                <div class="moneylineSelectorLi disable betTarget col-xs-6" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-primary" type="button" target_class="moneylineSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnMoneylineWrap"><?php echo __("Money <br> Line")?></button>
                                                </div>
                                                <div class="totalSelectorLi enable betTarget col-xs-6" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-primary" type="button" target_class="totalSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnTeamtotalWrap"><?php echo __("Total")?></button>
                                                </div>
                                        </div>
                                </td>
                                <td>&nbsp;</td>
                        </tr>
                </tbody>
        </table>
</div>
<div class="betTypeContainer">
        <table class="table-games sort">
                <tbody>
                        <?php foreach ($games as $row) {				
                                $dateWithTimeZone = strtotime ( "+".$timeZoneSeconds." second" , strtotime ( $row['gameHourFormat'] ) ) ;
                                $hourTimeZone = date ( 'h:i a' , $dateWithTimeZone );						
                                $hour_configured = substr($hourTimeZone, 0, -1);	
                        ?>
                        <tr class="odd">
                                <td id="timeCell" class="gameTime time-container" <?= $isOverview ? "minutes='".$row["minutesUntilStart"]."'" : "" ?>>
                                        <?php if ($row['liveIcon']) {?><div class='gameLiveIcon'></div><?php }?>
                                        <?php if ($row['circleIcon']){?><div class='gameCircledIcon'></div><?php }?>
                                        <div class="gameTime"><?=$row['gameDateFormat']?>&nbsp;<?=$hour_configured?></div>
                                </td>
                                <td>
                                        <div class="gameTitle moneylineSelectorLi_<?=$groupId?> show" ><?= $showDrawTitle ? $homeTitle : "&nbsp;" ?></div>               
                                </td>
                                <td>
                                        <div class="gameTitle moneylineSelectorLi_<?=$groupId?> show" ><?= $showDrawTitle ? $drawTitle : $homeTitle ?></div> 
                                        <div class="gameTitle totalSelectorLi_<?=$groupId?> hidden"><?= $over ?></div>   
                                </td>
                                <td>
                                        <div class="gameTitle moneylineSelectorLi_<?=$groupId?> show" ><?= $awayTitle ?></div> 
                                        <div class="gameTitle totalSelectorLi_<?=$groupId?> hidden"><?= $under ?></div>                    
                                </td>
                                <td></td>
                        </tr>
                        <tr class="<?php echo $row['gameNum']?> game odd" gamenum="<?php echo $row['gameNum']?>">
                                <td id="timeCell">
                                        <div class="gameInfo">
                                                <div class="team">
                                                        <div class="teamDesc">
                                                                <div class="TeamName european" ><?php echo $row['awayTeam']['teamName']?></div>
                                                                
                                                        </div><br>
                                                        <div class="teamDesc">
                                                                <div class="TeamName european" ><?php echo $row['homeTeam']['teamName']?></div>
                                                               
                                                        </div>
                                                </div>
                                        </div>
                                </td>
                                <td class="selectionWrap">
                                    <?php if($showDrawTitle){ ?>
                                        <div class="show moneyLine_<?=$groupId?>">
                                            <?php  if ($row['awayTeam']['moneyLine']['showField']) {?>
                                            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                            parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                                                            chosenTeamID = "<?php echo __($this->App->dictionary($row['awayTeam']['teamName'])) ?>"
                                                            groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                            betDescription = "<?php echo __($this->App->dictionary($row['awayTeam']['moneyLine']['betTypeDesc'])) ?>"
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
                                                            <div class="odds col-xs-12 col-lg-6">
                                                                    <?php if ($formatPriceAmerican)
                                                                                    echo $row['awayTeam']['moneyLine']['americanPrice'];
                                                                              else
                                                                                    echo $row['awayTeam']['moneyLine']['decimalPrice'];
                                                                    ?>
                                                            </div>
                                                    </div>
                                            </button>
                                            <?php }?>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="selectionWrap">                                        
                                        <div class="show moneyLine_<?=$groupId?>">                          
                                                <?php if($showDrawTitle){ ?>
                                                    <?php if ($row['draw']['moneyLine']['showField']) {?>
                                                        <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                                        parlayRestriction="<?php echo  $row['draw']['parlayRestriction']?>"
                                                                        chosenTeamID = "<?php echo __($this->App->dictionary( $row['draw']['teamName'])) ?>"
                                                                        groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                                        betDescription = "<?php echo __($this->App->dictionary($row['draw']['moneyLine']['betTypeDesc'])) ?>"
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
                                                                        selectionid="<?php echo $row['draw']['moneyLine']['selectorId']?>">
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
                                                <?php }
                                                
                                                    }else{ ?>
                                                        <?php  if ($row['awayTeam']['moneyLine']['showField']) {?>
                                                            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                                            parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                                                                            chosenTeamID = "<?php echo __($this->App->dictionary( $row['awayTeam']['teamName'])) ?>"
                                                                            groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                                            betDescription = "<?php echo __($this->App->dictionary($row['awayTeam']['moneyLine']['betTypeDesc'])) ?>"
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
                                                                            <div class="odds col-xs-12 col-lg-6">
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
                                            
                                                
                                                
                                        </div>
                                    <div class="hidden total_<?=$groupId?>">
                                                <?php if ($row['awayTeam']['total']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                                parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                                                                chosenTeamID="<?php echo __($this->App->dictionary($row['awayTeam']['total']['totalPointsOUDesc'])) ?>"
                                                                groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                                betDescription = "<?php echo __($this->App->dictionary($row['awayTeam']['total']['betTypeDesc'])) ?>"
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
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['awayTeam']['total']['totalPointsOU']?><?=$row['awayTeam']['total']['threshold']?></div>
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
                                        </div>
                                        
                                </td>
                                <td class="selectionWrap">
                                    <div class="show moneyLine_<?=$groupId?>">    
                                        <?php if ($row['homeTeam']['moneyLine']['showField']) {?>
                                            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                            parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                                                            chosenTeamID = "<?php echo __($this->App->dictionary( $row['homeTeam']['teamName'])) ?>"
                                                            groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                            betDescription = "<?php echo __($this->App->dictionary($row['homeTeam']['moneyLine']['betTypeDesc'])) ?>"
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
                                                            <div class="odds col-xs-12 col-lg-6">
                                                                    <?php if ($formatPriceAmerican)
                                                                                    echo $row['homeTeam']['moneyLine']['americanPrice'];
                                                                              else
                                                                                echo $row['homeTeam']['moneyLine']['decimalPrice'];
                                                                    ?>
                                                            </div>
                                                    </div>
                                            </button>
                                        <?php }?>
                                    </div>
                                    
                                        <div class="hidden total_<?=$groupId?>">
                                                
                                                <?php if ($row['homeTeam']['total']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"										
                                                                chosenTeamID="<?php echo __($this->App->dictionary($row['homeTeam']['total']['totalPointsOUDesc'])) ?>"
                                                                groupDescription = "<?php echo __($this->App->dictionary($row['periodDescription'])) ?>"
                                                                betDescription = "<?php echo __($this->App->dictionary($row['homeTeam']['total']['betTypeDesc'])) ?>"
                                                                betTypeis = "<?php echo  $row['homeTeam']['total']['betTypeis']?>"
                                                                mainBet="<?php echo $row['mainBet']?>"
                                                                dec = "<?php echo $row['homeTeam']['total']['decimalPrice']?>"
                                                                us = "<?php echo $row['homeTeam']['total']['americanPriceSF']?>"
                                                                gamenum="<?php echo $row['gameNum']?>"
                                                                periodNumber="<?php echo $row['periodNumber']?>"
                                                                threshold= "<?php echo $row['awayTeam']['total']['thresholdSF']?>"
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
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['homeTeam']['total']['totalPointsOU']?><?=$row['homeTeam']['total']['threshold']?>
                                                                </div>
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
                                        </div>
                                        
                                </td>
                                <td id='linkSelectGame_<?=$row['gameNum']?>'>
                                        <div class='link selectGame inner' GameNum='<?=$row['gameNum']?>' >
                                                <div class='counter'><?php echo (intval($row['countMarkets']) > 0) ? ($row['countMarkets'] - $countMarketsToRest) : ""?><div class='icon-caret'></div></div>
                                        </div>
                                </td>
                        </tr>
                        <tr>
                                <td style="text-align:left;" colspan="7">
                                    <div class='commentsTittle'><?php echo (empty($row['comments']) ? "" : "Game note:&nbsp;") ?></div><div class='comments' ><?php echo (empty($row['comments']) ? "" : $row['comments']) ?></div>
                                </td>
                        </tr>
                        <tr class="space border-top"><td colspan="5"></td></tr>
                        <?php  }?>
                </tbody>
        </table>
    <div class="divFillThrash">&nbsp;</div>
</div>
