<div class="betType">
        <table id="tableHeaderButton">
                <tbody>
                        <tr class="">
                                <td class="selectionWrap">
                                        <div class="betTypeSelector">
                                                <div class="spreadSelectorLi disable betTarget col-xs-3" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-success" type="button" target_class="spreadSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnSpreadWrap"><?php echo __("Spread")?></button>
                                                </div>
                                                <div class="moneylineSelectorLi enable betTarget col-xs-3" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-primary" type="button" target_class="moneylineSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnMoneylineWrap"><?php echo __("Money <br> Line")?></button>
                                                </div>
                                                <div class="totalSelectorLi disable betTarget col-xs-3" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-primary" type="button" target_class="totalSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnTeamtotalWrap"><?php echo __("Total")?></button>
                                                </div>
                                                <div class="teamtotalSelectorLi enable betTarget col-xs-3" >
                                                        <button class="btn btn-sm btn-md btn-primary-orange toggle_bettype btn-primary" type="button" target_class="teamtotalSelectorLi_<?=$groupId?>" id="<?=$groupId?>_<?=$periodSelected?>_btnTeamtotalWrap"><?php echo __("Team <br> Total")?></button>
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
                                        <div class="gameTitle spreadSelectorLi_<?=$groupId?> show">Spread</div>
                                        <div class="gameTitle moneylineSelectorLi_<?=$groupId?> hidden" >Money Line</div>
                                        <div class="gameTitle teamtotalSelectorLi_<?=$groupId?> hidden">Team Total</div>                   
                                </td>
                                <td>
                                        <div class="gameTitle totalSelectorLi_<?=$groupId?> show">Total</div>                    
                                </td>
                        </tr>
                        <tr class="<?php echo $row['gameNum']?> game odd" gamenum="<?php echo $row['gameNum']?>">
                                <td id="timeCell">
                                        <div class="gameInfo">
                                                <div class="team">
                                                        <div class="teamDesc">
                                                                <div class="RotNum"><?php echo (strlen($row['awayTeam']['rotNum'])>3) ? substr($row['awayTeam']['rotNum'],strlen($row['awayTeam']['rotNum'])-3,3) : $row['awayTeam']['rotNum']?>&nbsp;</div>
                                                                <div class="TeamName" style="width: 127px;"><?php echo $row['awayTeam']['teamName']?></div>
                                                                <?php 
                                                                    if($row["sportType"] == "Baseball"):
                                                                ?>
                                                                    <div class='teamPitcher'><?= ucwords(strtolower($row['listedPitcher1'])) ?></div>
                                                                <?php endif; ?>
                                                        </div>
                                                </div>
                                                <div class="team">
                                                        <div class="teamDesc">
                                                                <div class="RotNum"><?php echo (strlen($row['homeTeam']['rotNum'])>3) ? substr($row['homeTeam']['rotNum'],strlen($row['homeTeam']['rotNum'])-3,3) : $row['homeTeam']['rotNum']?>&nbsp;</div>
                                                                <div class="TeamName" style="width: 127px;"><?php echo $row['homeTeam']['teamName']?></div>
                                                                <?php 
                                                                    if($row["sportType"] == "Baseball"):
                                                                ?>
                                                                    <div class='teamPitcher'><?= ucwords(strtolower($row['listedPitcher2'])) ?></div>
                                                                <?php endif; ?>
                                                        </div>

                                                </div>
                                                <?php if ($row['draw']['rotNum'] != null) {?>
                                                <div class="team draw_<?=$groupId?> hidden">
                                                        <div class="teamDesc">
                                                                <div class="RotNum">&nbsp;</div>
                                                                <div class="TeamName" style="width: 127px;">Draw</div>
                                                        </div>
                                                </div>
                                                <?php }?>
                                        </div>
                                </td>
                                <td class="selectionWrap">
                                        <div class="show spread_<?=$groupId?>">
                                                <?php  if ($row['awayTeam']['spread']['showField']) {?>
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
                                                <br>
                                                <?php  if ($row['homeTeam']['spread']['showField']) {?>
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
                                        </div>
                                        <div class="hidden moneyLine_<?=$groupId?>">
                                                <?php  if ($row['awayTeam']['moneyLine']['showField']) {?>
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
                                                <br>
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
                                                <?php }?>
                                        </div>
                                        <div class="hidden teamTotalOver_<?=$groupId?>">
                                                <?php if ($row['awayTeam']['totalTeamOver']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                                parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                                                                chosenTeamID="<?php echo$row['awayTeam']['totalTeamOver']['totalPointsOUDesc']?>"
                                                                groupDescription = "<?php echo $row['periodDescription']?>"
                                                                betDescription = "<?php echo $row['awayTeam']['totalTeamOver']['betTypeDesc']." - ".$row['awayTeam']['teamName']?>"
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
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['awayTeam']['totalTeamOver']['totalPointsOU']?><?php echo $row['awayTeam']['totalTeamOver']['threshold']?>
                                                                </div>
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
                                                <br>
                                                <?php if ($row['homeTeam']['totalTeamOver']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"									
                                                                parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                                                                chosenTeamID="<?php echo $row['homeTeam']['totalTeamOver']['totalPointsOUDesc']?>"
                                                                betDescription = "<?php echo $row['homeTeam']['totalTeamOver']['betTypeDesc']." - ".$row['homeTeam']['teamName']?>"
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
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['homeTeam']['totalTeamOver']['totalPointsOU']?><?php echo $row['homeTeam']['totalTeamOver']['threshold']?>
                                                                </div>
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
                                        </div>
                                </td>
                                <td class="selectionWrap">
                                        <div class="show total_<?=$groupId?>">
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
                                                <br>
                                                <?php if ($row['homeTeam']['total']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"										
                                                                chosenTeamID="<?php echo$row['homeTeam']['total']['totalPointsOUDesc']?>"
                                                                groupDescription = "<?php echo $row['periodDescription']?>"
                                                                betDescription = "<?php echo $row['homeTeam']['total']['betTypeDesc']?>"
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
                                        <div class="hidden teamTotalUnder_<?=$groupId?>">
                                                <?php if ($row['awayTeam']['totalTeamUnder']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"									
                                                                parlayRestriction="<?php echo  $row['awayTeam']['parlayRestriction']?>"
                                                                chosenTeamID="<?php echo $row['awayTeam']['totalTeamUnder']['totalPointsOUDesc']?>"
                                                                betDescription = "<?php echo $row['awayTeam']['totalTeamUnder']['betTypeDesc']." - ".$row['awayTeam']['teamName']?>"
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
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['awayTeam']['totalTeamUnder']['totalPointsOU']?><?php echo $row['awayTeam']['totalTeamUnder']['threshold']?>
                                                                </div>
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
                                                <br>
                                                <?php if ($row['homeTeam']['totalTeamUnder']['showField']) {?>
                                                <button class="btn btn-primary btn-xs selection addToBetslip" type="button"
                                                                parlayRestriction="<?php echo  $row['homeTeam']['parlayRestriction']?>"
                                                                chosenTeamID="<?php echo$row['homeTeam']['totalTeamUnder']['totalPointsOUDesc']?>"
                                                                groupDescription = "<?php echo $row['periodDescription']?>"
                                                                betDescription = "<?php echo $row['homeTeam']['totalTeamUnder']['betTypeDesc']." - ".$row['homeTeam']['teamName']?>"
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
                                                                listedPitcher1 = "<?php  echo ucwords(strtolower($row['listedPitcher1'])) ?>"
                                                                listedPitcher2 = "<?php  echo ucwords(strtolower($row['listedPitcher2'])) ?>"
                                                                isParlay = "0"
                                                                isStraight = "<?php  echo $row['isStraight']?>"
                                                                isTeaser = "0"
                                                                selectionid="<?php echo $row['homeTeam']['totalTeamUnder']['selectorId']?>">
                                                        <div class="row">
                                                                <div class="threshold col-xs-12 col-lg-6">
                                                                        <?php echo $row['homeTeam']['totalTeamUnder']['totalPointsOU']?><?php echo $row['homeTeam']['totalTeamUnder']['threshold']?>
                                                                </div>
                                                                <div class="odds col-xs-12 col-lg-6">
                                                                        <?php  if ($formatPriceAmerican)
                                                                                         echo $row['homeTeam']['totalTeamUnder']['americanPrice'];
                                                                                   else
                                                                                        echo $row['homeTeam']['totalTeamUnder']['decimalPrice'];
                                                                        ?>
                                                                </div>
                                                        </div>
                                                </button>
                                                <?php }?>
                                        </div>
                                        <div class="hidden moneyLine_<?=$groupId?>">
                                                <?php if ($row['draw']['moneyLine']['showField']) {?>
                                                <div class="selection-white">
                                                        <div class="row">
                                                           <div class="odds col-xs-12"></div>
                                                        </div>
                                                </div>
                                                <?php } ?>	
                                        </div>
                                </td>
                                <td id='linkSelectGame_<?=$row['gameNum']?>'>
                                        <div class='link selectGame inner' GameNum='<?=$row['gameNum']?>' >
                                                <div class='counter'><?php echo (intval($row['countMarkets']) > 0) ? ($row['countMarkets'] - $countMarketsToRest) : ""?><div class='icon-caret'></div></div>
                                        </div>
                                        <div class='favorite-gen-start-container' meta-type='game' gamenum='<?php echo $row['gameNum']?>'>
                                            <i class='glyphicon glyphicon-star-empty'></i> 
                                            <i class='glyphicon glyphicon-star'></i>
                                        </div> 
                                </td>
                        </tr>
                        <tr>
                                <td style="text-align:left;" colspan="6">
                                    <div class='commentsTittle'><?php echo (empty($row['comments']) ? "" : "Game note:&nbsp;") ?></div><div class='comments' ><?php echo (empty($row['comments']) ? "" : $row['comments']) ?></div>
                                </td>
                        </tr>
                        <tr class="space border-top"><td colspan="4"></td></tr>
                        <?php  }?>
                </tbody>
        </table>
    <div class="divFillThrash">&nbsp;</div>
</div>
