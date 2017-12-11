<thead order='0'>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th><?php echo __("Spread")?></th>
        <th><?php echo __("Money Line")?></th>
        <th><?php echo __("Total")?></th>
        <th colspan='2'><?php echo __("Team Total")?></th>
        <th></th>
    </tr>
</thead>
<?php

  $auxDate = '';
  $j=0;
  foreach ($games as $row) {
        $dateWithTimeZone = strtotime ( "+".$timeZoneSeconds." second" , strtotime ( $row['gameHourFormat'] ) ) ;
        $hourTimeZone = date ( 'h:i a' , $dateWithTimeZone );				
        $hour_configured = substr($hourTimeZone, 0, -1);
        ?>
<?php if($j!=0){ ?>
<tbody class='space'><tr><td colspan='8'><hr style='margin: 0px;'></td></tr></tbody>
<?php } $j++; ?>

<tbody>
        <?php if (strcmp($auxDate,$row['gameDateFormat']) != 0) {?>
    <tr class="odd" style="height: 8px;">
        <td colspan="8" class="headersOverview"><span><?php echo __("Date")?>: <?=$row['gameDateFormat2']?></span></td>
    </tr>
        <?php
                $auxDate = $row['gameDateFormat'];
        }
        ?>
    <tr class='<?php  echo $row['gameNum']?> away' gamenum='<?php echo $row['gameNum']?>' >
        <td class='border-right gameDate' rowspan='3'  <?= $isOverview ? "minutes='".$row["minutesUntilStart"]."'" : "" ?>>
            <span class="date-span"><?php  echo $hour_configured?></span><br/>			
                        <?php if ($row['liveIcon']) {?><div class='gameLiveIcon'></div><?php }?>
                        <?php if ($row['circleIcon']){?><div class='gameCircledIcon'></div><?php }?>
            <!--a href='#' class='link selectGame' GameNum='$row['gameNum']?>'>
               <span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span>
            </a-->
            <div class='favorite-gen-start-container' meta-type='game' gamenum='<?php echo $row['gameNum']?>'>
                <i class='glyphicon glyphicon-star-empty'></i> 
                <i class='glyphicon glyphicon-star'></i>
            </div>
        </td>
        <td class='border-bottom teamInfo'>
            <div class='teamSerial'><?php echo (strlen($row['awayTeam']['rotNum'])>3) ? substr($row['awayTeam']['rotNum'],strlen($row['awayTeam']['rotNum'])-3,3) : $row['awayTeam']['rotNum'] ?>&nbsp;</div>
            <div class='teamName'><?php echo (substr($row['awayTeam']['teamName'], 0, 1) == "." ? substr($row['awayTeam']['teamName'], 1) : $row['awayTeam']['teamName']) ?></div>
                        <?php 
                            if($row["sportType"] == "Baseball"):
                        ?>
            <div class='teamPitcher'><?= ucwords(strtolower($row['listedPitcher1'])) ?></div>
                        <?php endif; ?>
        </td>
        <td class='border-bottom selectionWrap spread'>
                        <?php if ($row['awayTeam']['spread']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"								
                    chosenTeamID="<?php echo  $row['awayTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['awayTeam']['spread']['betTypeDesc']?>"
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
                    <div class="threshold col-xs-12 col-lg-6"><?php echo $row['awayTeam']['spread']['threshold']?></div>
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
        </td>
        <td class='border-bottom selectionWrap moneyLine'>
                        <?php if ($row['awayTeam']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo  $row['awayTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['awayTeam']['moneyLine']['betTypeDesc']?>"
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
        </td>               
        <td class='border-bottom selectionWrap total'>
                        <?php if ($row['awayTeam']['total']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo$row['awayTeam']['total']['totalPointsOUDesc']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['awayTeam']['total']['betTypeDesc']?>"
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
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['awayTeam']['total']['totalPointsOU']?><?php echo $row['awayTeam']['total']['threshold']?></div>
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
        <td class='border-bottom selectionWrap teamTotalOver'>
                        <?php if ($row['awayTeam']['totalTeamOver']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo $row['awayTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['awayTeam']['totalTeamOver']['betTypeDesc']." - ".$row['awayTeam']['totalTeamOver']['totalPointsOUDesc']?>"
                    betTypeis = "<?php echo  $row['awayTeam']['totalTeamOver']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['awayTeam']['totalTeamOver']['decimalPrice']?>"
                    us = "<?php echo $row['awayTeam']['totalTeamOver']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['awayTeam']['totalTeamOver']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['awayTeam']['totalTeamOver']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['awayTeam']['totalTeamOver']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['awayTeam']['totalTeamOver']['totalPointsOU']?><?php echo $row['awayTeam']['totalTeamOver']['threshold']?></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['awayTeam']['totalTeamOver']['americanPrice'];
                               else	
                                     echo $row['awayTeam']['totalTeamOver']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
        <td class='border-bottom selectionWrap teamTotalUnder'>
                         <?php if ($row['awayTeam']['totalTeamUnder']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"                         
                    parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo $row['awayTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['awayTeam']['totalTeamUnder']['betTypeDesc']." - ".$row['awayTeam']['totalTeamUnder']['totalPointsOUDesc']?>"
                    betTypeis = "<?php echo  $row['awayTeam']['totalTeamUnder']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['awayTeam']['totalTeamUnder']['decimalPrice']?>"
                    us = "<?php echo $row['awayTeam']['totalTeamUnder']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['awayTeam']['totalTeamUnder']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['awayTeam']['totalTeamUnder']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['awayTeam']['totalTeamUnder']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['awayTeam']['totalTeamUnder']['totalPointsOU']?><?php echo $row['awayTeam']['totalTeamUnder']['threshold']?></div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['awayTeam']['totalTeamUnder']['americanPrice'];
                              else
                                    echo $row['awayTeam']['totalTeamUnder']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
        <td id='linkSelectGame_<?php echo $row['gameNum']?>' style='width: 60px;background-color: #2f3c42; border-radius: 4px' rowspan='3'>
            <div class='link selectGame' GameNum='<?php echo $row['gameNum']?>' style='height: 72px;'>
                <div class='link selectGame outer' GameNum='<?php echo $row['gameNum']?>' style='height: 72px;'>
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
    <tr class='<?php echo $row['gameNum']?> home' gamenum='<?php echo $row['gameNum']?>'>
        <td class='border-bottom teamInfo'>
            <div class='teamSerial'><?php echo (strlen($row['homeTeam']['rotNum'])>3) ? substr($row['homeTeam']['rotNum'],strlen($row['homeTeam']['rotNum'])-3,3) : $row['homeTeam']['rotNum']?>&nbsp;</div>
            <div class='teamName'><?php echo (substr($row['homeTeam']['teamName'], 0, 1) == "." ? substr($row['homeTeam']['teamName'], 1) : $row['homeTeam']['teamName']) ?></div>
                        <?php 
                            if($row["sportType"] == "Baseball"):
                        ?>
            <div class='teamPitcher'><?= ucwords(strtolower($row['listedPitcher2'])) ?></div>
                        <?php endif; ?>
        </td>
        <td class='border-bottom selectionWrap spread'>
                         <?php if ($row['homeTeam']['spread']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo  $row['homeTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['homeTeam']['spread']['betTypeDesc']?>"
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
                    <div class="threshold col-xs-12 col-lg-6"><?php echo $row['homeTeam']['spread']['threshold']?></div>
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
        </td>
        <td class='border-bottom selectionWrap moneyLine'>
                         <?php if ($row['homeTeam']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo  $row['homeTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['homeTeam']['moneyLine']['betTypeDesc']?>"
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
                        <?php }?>
        </td>
        <td class='border-bottom selectionWrap total'>
                        <?php if ($row['homeTeam']['total']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo$row['homeTeam']['total']['totalPointsOUDesc']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['homeTeam']['total']['betTypeDesc']?>"
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
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['homeTeam']['total']['totalPointsOU']?><?php echo $row['homeTeam']['total']['threshold']?> </div>
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
        <td class='border-bottom selectionWrap teamTotalOver'>
                        <?php if ($row['homeTeam']['totalTeamOver']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo $row['homeTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['homeTeam']['totalTeamOver']['betTypeDesc']." - ".$row['homeTeam']['totalTeamOver']['totalPointsOUDesc']?>"
                    betTypeis = "<?php echo  $row['homeTeam']['totalTeamOver']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['totalTeamOver']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['totalTeamOver']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['homeTeam']['totalTeamOver']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['homeTeam']['totalTeamOver']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['homeTeam']['totalTeamOver']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['homeTeam']['totalTeamOver']['totalPointsOU']?><?php echo $row['homeTeam']['totalTeamOver']['threshold']?> </div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['totalTeamOver']['americanPrice'];
                               else
                                    echo $row['homeTeam']['totalTeamOver']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
        <td class='border-bottom selectionWrap teamTotalUnder'>
                         <?php if ($row['homeTeam']['totalTeamUnder']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip"  type="button"
                    parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                    chosenTeamID="<?php echo $row['homeTeam']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['homeTeam']['totalTeamUnder']['betTypeDesc']." - ".$row['homeTeam']['totalTeamUnder']['totalPointsOUDesc']?>"
                    betTypeis = "<?php echo  $row['homeTeam']['totalTeamUnder']['betTypeis']?>"
                    mainBet="<?php echo $row['mainBet']?>"
                    dec = "<?php echo $row['homeTeam']['totalTeamUnder']['decimalPrice']?>"
                    us = "<?php echo $row['homeTeam']['totalTeamUnder']['americanPriceSF']?>"
                    gamenum="<?php echo $row['gameNum']?>"
                    periodNumber="<?php echo $row['periodNumber']?>"
                    threshold= "<?php echo $row['homeTeam']['totalTeamUnder']['thresholdSF']?>"
                    totalPointsOU= "<?php echo $row['homeTeam']['totalTeamUnder']['totalPointsOU']?>"
                    sportType= "<?php echo $sportType?>"
                    sportSubType= "<?php echo $sportSubType?>"
                    listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1']))?>"
                    listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2']))?>"
                    isParlay = "0"
                    isStraight = "<?php  echo $row['isStraight']?>"
                    isTeaser = "0"
                    selectionid="<?php echo $row['homeTeam']['totalTeamUnder']['selectorId']?>">
                <div class="row">
                    <div class="threshold col-xs-12 col-lg-6"><?php echo$row['homeTeam']['totalTeamUnder']['totalPointsOU']?><?php echo $row['homeTeam']['totalTeamUnder']['threshold']?> </div>
                    <div class="odds col-xs-12 col-lg-6">
                    <?php if ($formatPriceAmerican)
                                    echo $row['homeTeam']['totalTeamUnder']['americanPrice'];
                              else
                                echo $row['homeTeam']['totalTeamUnder']['decimalPrice'];
                    ?>
                    </div>
                </div>
            </button>
                        <?php }?>
        </td>
    </tr>

        <?php if ($row['draw']['rotNum'] != null) {?>
    <tr class='<?=$row['gameNum']?> draw' gamenum='<?=$row['gameNum']?>'>
        <td class='border-bottom teamInfo'>
            <div class='teamName'><?=$row['draw']['teamName']?></div>
        </td>
        <td class='border-bottom selectionWrap spread'></td>
        <td class='border-bottom selectionWrap moneyLine'>
                         <?php if ($row['draw']['moneyLine']['showField']) {?>
            <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                    parlayRestriction="<?php echo  $row['draw']['parlayRestriction']?>"
                    chosenTeamID="<?php echo  $row['draw']['teamName']?>"
                    groupDescription = "<?php echo $row['periodDescription']?>"
                    betDescription = "<?php echo $row['draw']['moneyLine']['betTypeDesc']?>"
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
        </td>
        <td class='border-bottom selectionWrap total'></td>
        <td class='border-bottom selectionWrap teamTotalOver'></td>
        <td class='border-bottom selectionWrap teamTotalUnder'></td>
    </tr>		
        <?php }?>
    <tr>
        <td style="text-align:left;" colspan="6">
            <div class='commentsTittle'><?php echo (empty($row['comments']) ? "" : "Game note:&nbsp;") ?></div><div class='comments' ><?php echo (empty($row['comments']) ? "" : $row['comments']) ?></div>
        </td>
    </tr>
</tbody>
  <?php  }?>
<tbody class="space border-bottom"><tr class="odd"><td colspan="8"></td></tr></tbody>
<tbody class="space"><tr class="odd"><td colspan="8"></td></tr></tbody>
