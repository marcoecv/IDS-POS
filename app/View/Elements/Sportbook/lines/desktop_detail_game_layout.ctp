<div class="group containerForMasiveToggle" id="game_<?php echo $period['gameNum']?>_<?php echo $period['periodNumber']?>" order="0">
    <div class="title <?php echo ($i==0)?'':'collapsed'; ?>" data-toggle="collapse" aria-expanded='<?php echo ($i==0)?'true':'false'; ?>' href="#body_game_<?php echo $period['gameNum']?>_<?php echo $period['periodNumber']?>">
      <?php echo ucfirst(strtolower(__($this->App->dictionary($period['periodDescription']))))?>
       <div class="toggle-icon"></div>
    </div>
    <div id="body_game_<?php echo $period['gameNum']?>_<?php echo $period['periodNumber']?>" class="<?php echo ($i==0)?'in':'collapse'; ?>">
       <table class="table-games">
          <thead>
             <tr class="border-bottom">
                <th></th>
                <th><?php echo __('Spread')?></th>
                <th><?php echo __('Money Line')?></th>
                <th><?php echo __('Total')?></th>
                <th colspan="2"><?php echo __('Team Total')?></th>
             </tr>
          </thead>
          <tbody>
            <?php if(isset($period['awayTeam'])){?>
            <tr class="border-bottom">
                <td class="teamInfo">
                   <div class="teamSerial"><?php echo (strlen($period['awayTeam']['rotNum'])>3) ? substr($period['awayTeam']['rotNum'],strlen($period['awayTeam']['rotNum'])-3,3) : $period['awayTeam']['rotNum']?>&nbsp;</div>
                   <div class="teamName"><?php echo (substr($period['awayTeam']['teamName'], 0, 1) == "." ? substr($period['awayTeam']['teamName'], 1) : $period['awayTeam']['teamName']) ?></div>
                    <?php 
                        if($period["sportType"] == "Baseball"):
                    ?>
                        <div class="listedPitcher"><?= ucwords(strtolower($period['listedPitcher1'])) ?></div>
                    <?php endif; ?>
                </td>
                <?php foreach($period['awayTeam'] as $key=>$bet){
                if(is_array($bet)){

                    $chosenTeamID='';
                    $threshold = $bet['threshold'];

                                                if($key!='total'){
                                                        $chosenTeamID=$period['awayTeam']['teamName']; 
                                                }else{
                                                        $chosenTeamID = $bet['totalPointsOUDesc'];
                                                }

                                                if($key!='moneyLine' && $key!='spread'){                              
                       $threshold = $bet['totalPointsOU'].''.$bet['threshold'];
                    }

                                                $betDescription ='';
                                                if($key!='totalTeamUnder' && $key!='totalTeamOver'){
                                                        $betDescription = $bet['betTypeDesc'];
                                                }else{								
                                                        $betDescription = $bet['betTypeDesc']." - ".$bet['totalPointsOUDesc'];
                                                }
                ?>
                <td class="selectionWrap <?php echo $key.'Away'?>">
                   <?php $secret=(empty($bet['threshold']) && empty($bet['americanPrice']))?'secret':'';?>
                                           <?php if ($bet['showField']) {?>
                   <button class="btn btn-primary btn-xs selection addToBetslip text-center <?php echo $secret?>" type="button"
                           parlayRestriction="<?php echo $period['awayTeam']['parlayRestriction']?>"
                           chosenTeamID="<?php echo $chosenTeamID?>"
                           groupDescription = "<?php echo $period['periodDescription']?>"
                           betDescription = "<?php echo $betDescription?>"
                           betTypeis = "<?php echo  $bet['betTypeis']?>"
                           mainBet="<?php echo $period['mainBet']?>"
                           dec = "<?php echo $bet['decimalPrice']?>"
                           us = "<?php echo $bet['americanPriceSF']?>"
                           gamenum="<?php echo $period['gameNum']?>"
                           periodNumber="<?php echo $period['periodNumber']?>"
                           threshold= "<?php echo $bet['thresholdSF']?>"
                                                           totalPointsOU= "<?php echo $bet['totalPointsOU']?>"
                           sportType= "<?php echo $sport?>"
                           sportSubType= "<?php echo $league?>"
                           listedPitcher1 = "<?php  echo ucwords(strtolower($period['listedPitcher1']))?>"
                                                           listedPitcher2 = "<?php  echo ucwords(strtolower($period['listedPitcher2']))?>"
                                                           isParlay = "<?php  echo $period['isParlay']?>"
                                                           isStraight = "<?php  echo $period['isStraight']?>"
                                                           isTeaser = "<?php  echo $period['isTeaser']?>"
                           selectionid="<?php echo $bet['selectorId']?>">
                      <div class="row">
                         <?php if($key!='moneyLine'){ ?>
                            <div class="threshold col-xs-12 <?php echo ($key!='moneyLine')?'col-lg-6':'col-lg-12';?>"><?php echo $threshold;?></div>
                        <?php }?>
                            <div class="odds col-xs-12 <?php echo ($key!='moneyLine')?'col-lg-6':'col-lg-12';?>">
                                                                        <?php if ($formatPriceAmerican)
                                                                                        echo $bet['americanPrice'];
                                                                                  else
                                                                                    echo $bet['decimalPrice'];
                                                                        ?>
                                                                </div>
                      </div>
                   </button>
                                           <?php } ?>
                </td>
                <?php }} ?>
            </tr>
            <?php } ?>
            <?php if(isset($period['homeTeam'])){?>
            <tr class="border-bottom">
                <td class="teamInfo">
                   <div class="teamSerial"><?php echo (strlen($period['homeTeam']['rotNum'])>3) ? substr($period['homeTeam']['rotNum'],strlen($period['homeTeam']['rotNum'])-3,3) : $period['homeTeam']['rotNum']?>&nbsp;</div>
                   <div class="teamName"><?php echo (substr($period['homeTeam']['teamName'], 0, 1) == "." ? substr($period['homeTeam']['teamName'], 1) : $period['homeTeam']['teamName']); ?></div>
                   <?php 
                        if($period["sportType"] == "Baseball"):
                    ?>
                        <div class="listedPitcher"><?= ucwords(strtolower($period['listedPitcher2'])) ?></div>
                    <?php endif; ?>
                </td>
                <?php foreach($period['homeTeam'] as $key=>$bet){
                    
                    if($key == "doubleChanceProp" || $key == "goalNoGoalProp"){
                        continue;
                    }
                    
                if(is_array($bet)){

                    $chosenTeamID='';
                    $threshold = $bet['threshold'];

                                                if($key!='total'){
                                                        $chosenTeamID=$period['homeTeam']['teamName']; 
                                                }else{
                                                        $chosenTeamID = $bet['totalPointsOUDesc'];
                                                }

                    if($key!='moneyLine' && $key!='spread'){                              
                       $threshold = $bet['totalPointsOU'].''.$bet['threshold'];
                    }

                                                $betDescription ='';
                                                if($key!='totalTeamUnder' && $key!='totalTeamOver'){
                                                        $betDescription = $bet['betTypeDesc'];								
                                                }else{
                                                        $betDescription = $bet['betTypeDesc']." - ".$bet['totalPointsOUDesc'];
                                                }

                ?>
                <td class="selectionWrap <?php echo $key.'Home'?>">
                   <?php $secret=(empty($bet['threshold']) && empty($bet['americanPrice']))?'secret':'';?>
                   <?php if ($bet['showField']) {?>
                                           <button class="btn btn-primary btn-xs selection addToBetslip text-center <?php echo $secret?>" type="button"
                           parlayRestriction="<?php echo $period['homeTeam']['parlayRestriction']?>"
                           chosenTeamID="<?php echo $chosenTeamID?>"
                           groupDescription = "<?php echo $period['periodDescription']?>"
                           betDescription = "<?php echo $betDescription?>"
                           betTypeis = "<?php echo  $bet['betTypeis']?>"
                           mainBet="<?php echo $period['mainBet']?>"
                           dec = "<?php echo $bet['decimalPrice']?>"
                           us = "<?php echo $bet['americanPriceSF']?>"
                           gamenum="<?php echo $period['gameNum']?>"
                           periodNumber="<?php echo $period['periodNumber']?>"
                           threshold= "<?php echo $bet['thresholdSF']?>"
                                                           totalPointsOU= "<?php echo $bet['totalPointsOU']?>"
                           sportType= "<?php echo $sport?>"
                           sportSubType= "<?php echo $league?>"
                           listedPitcher1 = "<?php  echo ucwords(strtolower($period['listedPitcher1']))?>"
                                                           listedPitcher2 = "<?php  echo ucwords(strtolower($period['listedPitcher2']))?>"
                                                           isParlay = "<?php  echo $period['isParlay']?>"
                                                           isStraight = "<?php  echo $period['isStraight']?>"
                                                           isTeaser = "<?php  echo $period['isTeaser']?>"
                           selectionid="<?php echo $bet['selectorId'];?>">
                      <div class="row">
                        <?php if($key!='moneyLine'){ ?><div class="threshold col-xs-12 col-lg-6"><?php echo $threshold;?></div><?php }?>
                        <div class="odds col-xs-12 <?php echo ($key!='moneyLine')?'col-lg-6':'col-lg-12';?>">
                                                                <?php if ($formatPriceAmerican)
                                                                                echo $bet['americanPrice'];
                                                                          else
                                                                                echo $bet['decimalPrice'];
                                                                ?>
                                                        </div>
                      </div>
                   </button>
                                           <?php } ?>
                </td>
                <?php }} ?>
             </tr>
            <?php } ?>
            <?php if(isset($period['draw'])){
                                         if ($period['draw']['moneyLine']['showField']) {
                                ?>
            <tr class="border-bottom">
                <td class="teamInfo">
                   <div class="teamName"><?php echo __('Draw')?></div>
                   <div class="listedPitcher"></div>
                </td>
                <td class="selectionWrap"></td>
                <td class="selectionWrap moneyLineDraw">
                   <?php $secret=(empty($period['draw']['moneyLine']['americanPrice']))?'secret':'';?>
                   <button class="btn btn-primary btn-xs selection addToBetslip <?php echo $secret?>" type="button"
                           parlayRestriction="<?php echo $period['awayTeam']['parlayRestriction']?>"
                           chosenTeamID="<?php echo $period['draw']['teamName']?>"
                           groupDescription = "<?php echo $period['periodDescription']?>"
                           betTypeis = "<?php echo  $period['draw']['moneyLine']['betTypeis']?>"
                           mainBet="<?php echo $period['mainBet']?>"
                           dec = "<?php echo $period['draw']['moneyLine']['decimalPrice']?>"
                           us = "<?php echo $period['draw']['moneyLine']['americanPriceSF']?>"
                           gamenum="<?php echo $period['gameNum']?>"
                           periodNumber="<?php echo $period['periodNumber']?>"
                           sportType= "<?php echo $sport?>"
                           sportSubType= "<?php echo $league?>"
                           listedPitcher1 = "<?php  echo ucwords(strtolower($period['listedPitcher1']))?>"
                                                           listedPitcher2 = "<?php  echo ucwords(strtolower($period['listedPitcher2']))?>"
                                                           isParlay = "<?php  echo $period['isParlay']?>"
                                                           isStraight = "<?php  echo $period['isStraight']?>"
                                                           isTeaser = "<?php  echo $period['isTeaser']?>"
                           selectionid="<?php echo $period['draw']['moneyLine']['selectorId'];?>">
                      <div class="row">
                        <div class="odds col-xs-12 col-lg-12">
                                                                <?php if ($formatPriceAmerican)
                                                                                echo $period['draw']['moneyLine']['americanPrice'];
                                                                          else
                                                                                echo $period['draw']['moneyLine']['decimalPrice'];
                                                                ?>
                                                        </div>
                      </div>
                   </button>
                </td>
                <td class="selectionWrap"></td>
                <td class="selectionWrap"></td>
                <td class="selectionWrap"></td>
             </tr>					 
            <?php }
                                }
                                ?>
                                <tr>
                                        <td style="text-align: left;" colspan="6">
                                            <div class='commentsTittle'><?php echo (empty($period['comments']) ? "" : "Game note:&nbsp;") ?></div><div class="comments"><?php echo (empty($period['comments']) ? "" : __($this->App->dictionary($period['comments']))) ?></div>
                                        </td>
                                 </tr>
          </tbody>
       </table>
    </div>
 </div>


