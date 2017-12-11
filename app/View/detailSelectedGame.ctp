
<?php 
if(!empty($selectedGameNum)){?>
<div id='game_<?=$selectedGameNum;?>'>
    <div id='gameWrapDesktop' class='sort hidden-xs'>
    <table class='gameHeader margin-bottom border'>
    <tr class='border-bottom'>
        <td class='backButtonTd border-right'>
        <center>
            <div class='backButtonWrap'>
                <button type='button' class='btn btn-danger get-back-button'>Back</button>
            </div>
        </center>
        <td>
        <center>
            <table>
            <tr>
                <td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;
                    <!--<img class='teamImage' src='/images/team1.gif' alt=''/>-->
                </td>
                <td class='teamsTd teamHome h4'><?php echo @$data['general']['title'] ?></td>
                <td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;
                    <!--<img class='teamImage' src='/images/team2.gif' alt=''/>-->
                </td>
            </tr>
            </table>
        </center>
        </td>
    </tr>
    <tr>
        <td colspan='8' class='dateTd'><?php echo @$data['general']['dateGame']?></td>
    </tr>
    </table>
    <?php if(!empty($data['periods'])){?>
    <div class='mainBetsWrap toggleContainersParent'>
        <div class='groupTitle' style="height: 25px">
            Main Bets
            <div class='toggleContainers'>
                <div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this);'>Open All</button></div>
                <div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this);'>Close All</button></div>
            </div>
        </div>
        <div class='groupsWrapLong sort'>
    
        <?php $i=0;
        foreach($data['periods'] as $period){ ?>
        <div class="group containerForMasiveToggle"  id="game_<?php echo $period['gameNum']?>_<?php echo $period['periodNumber']?>" order="0">
            <div class="title <?php echo ($i==0)?'':'collapsed'; ?>" data-toggle="collapse" style='height: 40px;line-height: 36px;' aria-expanded='<?php echo ($i==0)?'true':'false'; ?>' href="#body_game_<?php echo $period['gameNum']?>_<?php echo $period['periodNumber']?>">
               <?php echo ucfirst(strtolower($period['periodDescription']))?>
               <div class="toggle-icon" style='height: 40px;line-height: 36px;'></div>
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
                           <div class="listedPitcher"></div>
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
                                   listedPitcher1 = "<?php  echo $period['listedPitcher1']?>"
								   listedPitcher2 = "<?php  echo $period['listedPitcher2']?>"
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
                           <div class="listedPitcher"></div>
                        </td>
                        <?php foreach($period['homeTeam'] as $key=>$bet){
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
                                   listedPitcher1 = "<?php  echo $period['listedPitcher1']?>"
								   listedPitcher2 = "<?php  echo $period['listedPitcher2']?>"
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
                           <div class="teamName">Draw</div>
                           <div class="listedPitcher"></div>
                        </td>
                        <td class="selectionWrap"></td>
                        <td class="selectionWrap moneyLineDraw">
                           <?php $secret=(empty($period['draw']['moneyLine']['americanPrice']))?'secret':'';?>
                           <button class="btn btn-primary btn-xs selection addToBetslip <?php echo $secret?>" type="button"
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
                                   listedPitcher1 = "<?php  echo $period['listedPitcher1']?>"
								   listedPitcher2 = "<?php  echo $period['listedPitcher2']?>"
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
						<td style="align-content: center" colspan="6">
							<div class="comments"><?php echo $period['comments']?></div>
						</td>
					 </tr>
                  </tbody>
               </table>
            </div>
         </div>
        <?php $i++; } // fin foreach ?>
        </div>
    </div>
    <?php } // fin if period ?>
</div><!-- fin bloc game desktop -->
    
<div id='gameWrapMobil' class='sort visible-xs'>
    <?php if(!empty($selectedGameNum)){?>
    <div id='game_<?=$selectedGameNum;?>'>
        <table class='gameHeader margin-bottom border'>
        <tr class='border-bottom'>
            <td class='backButtonTd border-right'>
            <center>
                <div class='backButtonWrap get-back-button'>
                <button type='button' class='btn btn-danger showLines'>Back</button>
                </div>
            </center>
            <td>
            <center>
                <table>
                <tr>
                    <td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;</td>
                    <td class='teamsTd teamHome h4'><?=@$data['general']['title'] ?></td>
                    <td class='imageTd hidden-xs hidden-sm hidden-md'>&nbsp;</td>
                </tr>
                </table>
            </center>
            </td>
        </tr>
        <tr>
            <td colspan='8' class='dateTd'><?=@$data['general']['dateGame']?></td>
        </tr>
        </table>
        <div id='mainBetsGroupsWrap' class='sort'>
            <div id='mainBetsGroupsWrap_mainBet' class='group toggleContainersParent'>
                <div class='groupTitle h4' style="height: 25px">Main Bets
                    <div class='toggleContainers'>
                    <div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this)'>Open All</button></div>
                    <div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this)'>Close All</button></div>
                    </div>
                </div>
                <div class='betsWrap sort'>
                <?php if(!empty($data['periods'])){
                    $betOpen=true;?>
                    <?php foreach($data['periods'] as $key=>$period){ 
                        if(!empty($period['homeTeam']['spread']) && !empty($period['awayTeam']['spread']) ) 
                            echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['spread'], $period['awayTeam']['spread'], null, true, 'spread', null, $sport, $league, $formatPriceAmerican);
                        
                        if(!empty($period['homeTeam']['moneyLine']) && !empty($period['awayTeam']['moneyLine']) )
                            echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['moneyLine'], $period['awayTeam']['moneyLine'], $period['draw']['moneyLine'], false, 'moneyLine', null, $sport, $league, $formatPriceAmerican);
                        
                        if(!empty($period['homeTeam']['total']) && !empty($period['awayTeam']['total']) )
                            echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['total'], $period['awayTeam']['total'], null, false, 'total', null, $sport, $league, $formatPriceAmerican);
                        
                        if(!empty($period['homeTeam']['totalTeamOver']) && !empty($period['homeTeam']['totalTeamUnder']) )
                            echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['totalTeamOver'], $period['homeTeam']['totalTeamUnder'], null, false, 'teamTotal','homeTeam', $sport, $league, $formatPriceAmerican);
                        
                        if(!empty($period['awayTeam']['totalTeamOver']) && !empty($period['awayTeam']['totalTeamUnder']) )
                            echo $this->Sportbook->addMainBetsGroups($period, $period['awayTeam']['totalTeamOver'], $period['awayTeam']['totalTeamUnder'], null, false, 'teamTotal','awayTeam', $sport, $league, $formatPriceAmerican);
                    } // foreach ?>
                <?php } // if?>
                </div>
				<div><div class="comments"><?php echo $period['comments']?></div></div>
            </div>
        </div>
    </div>
    <?php }?>
</div><!-- fin bloc game mobile -->
    
<?php

  if ($data['showProps']){	

	if(!empty($data['gameProps'])){
	
?>
    <div id='propsGroupsWrapLong'>
        <?php foreach($data['gameProps'] as $groups){
            $groupContainerId='propsgroupswraplong_'.$this->Sportbook->sanitiazeId($groups['description']);
            ?>
            <div id='<?php echo $groupContainerId?>' class='group toggleContainersParent'>
            <div class='groupTitle h4' style="height: 25px">
                <?php echo $groups['description']?>
                <div class='toggleContainers'>
                <div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this);'>Open All</button></div>
                <div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this);'>Close All</button></div>
                </div>
            </div>
            <div class='betsWrap sort'>
            <?php if(!empty($groups['listGroupProp'])){?>
                <?php foreach($groups['listGroupProp'] as $props){ 
                $selectionContainerId='data_'.$props['gameNum'].'_'.$this->Sportbook->sanitiazeId($props['contestType2']).'_'.$props['gameNum'].'_'.$props['contestNum'];
                ?>
                  <div id="group_contest_<?php echo $props['contestNum']?>" class="table-games bet containerForMasiveToggle" contestId="<?=$props['contestNum']?>">
                    <div class='title header collapsed' data-toggle='collapse' aria-expanded='false' href='#<?php echo $selectionContainerId?>'>
                        <div class='ellipsis'>
                            <div class='titleText'><?php echo $props['contestDescription']?></div>
                        </div>
                        <div class='toggle-icon'></div>
                    </div>
                    <div id='<?=$selectionContainerId?>' class='collapse'>
                        <ul id ='list_group_<?php echo $props['contestNum']?>' class='selectionList row sort'>
                            <?php 
                            $order=1;
                            $colClass = 'col-xs-12';
                            $countProps = count($props['listProps']);
                            if ($countProps > 1)
                                $colClass = ($countProps == 2) ? 'col-xs-6':'col-xs-4';
                            ?>
                            <?php foreach($props['listProps'] as $prop){
                                $contestantId=$props['gameNum'].'_'.$props['contestNum'].'_'.$prop['contestantNum'];?>
                            <li class='addToBetslip <?=$colClass?>' id='propsgroupswraplong_<?=$contestantId?>'
                                chosenTeamID="<?=$prop['contestantName']?>"
                                groupDescription = "<?php echo $groups['description']?>"
								betTypeis = "<?php echo $prop['betTypeis']?>"
                                betDescription = "<?php echo $props['contestDescription']?>"
                                contestNum="<?php echo $props['contestNum']?>"
                                contestantNum = "<?php echo $prop['contestantNum']?>"
								threshold = "<?php echo $prop['thresholdLineSF']?>"
                                mainBet="<?php echo $groups['mainBet']?>"
                                dec = "<?php echo $prop['decimalOdds']?>"
                                us = "<?php echo $prop['moneyLine']?>"
                                gamenum="<?php echo $props['gameNum']?>"                              
                                isfuture= "<?php echo $groups['isFeatureProps']?>"
								isParlay= "<?php echo $groups['isParlay']?>"
                                isStraight= "<?php echo $groups['isStraight']?>"
                                isTeaser= "<?php echo $groups['isTeaser']?>"
                                sportType= "<?php echo $sport?>"
                                sportSubType= "<?php echo $league?>"                            
                                selectionid='<?php echo $contestantId?>'>
                                <div class='selectionTable' style='<?=($countProps>=3?"height:40px;":"")?>'>
                                    <div class='selectionFix'>
                                        <div class='selectionDesc' style='text-align: center;'><?=$prop['contestantName']?></div>                                        
                                        <div class='noWrap' style='text-align: center;'>
                                            <span class='selectionThreshold threshold'><?php echo $prop['thresholdLine']?></span>
                                            <span class='selectionOdds odds'>
												<?php if ($formatPriceAmerican)
														echo $prop['moneyLine'];
													  else
														echo $prop['decimalOdds'];
												?>
											</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php } // foreach ?>
                        </ul>
                       <?=$props['comments']?>
                    </div>
                </div>
                <?php } // foreach ?>
            <?php } // if ?>
            
            </div>
            </div>
        <?php } // foreach ?>
    </div><!-- fin bloc props -->
    <?php }
	}
	?>  
    
</div> <!-- fin bloc selected game -->
<?php } ?>
