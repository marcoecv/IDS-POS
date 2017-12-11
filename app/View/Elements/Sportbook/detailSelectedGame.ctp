
<?php
if(!empty($selectedGameNum)){?>
<div id='game_<?php echo $selectedGameNum;?>'>
    <div id='gameWrapDesktop' class='sort hidden-xs'>
    <table class='gameHeader margin-bottom'>
    <tr>
        <td class='backButtonTd'>
        <center>
            <div class='backButtonWrap'>
                <button type='button' class='btn btn-danger get-back-button'><?=__('Back')?></button>
            </div>
        </center>
        <td>
        <center>
            <table style="margin-top:10px;">
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
    <?php 
    if(!empty($data['general']['dateGame'])) { ?>
    <tr>
        <td colspan='8' class='dateTd'><?php echo @$data['general']['dateGame']?></td>
    </tr>
    <?php } ?>
    </table>
    <?php if(!empty($data['periods'])){?>
    <div class='mainBetsWrap toggleContainersParent'>
        <div class='groupTitle' style="height: 25px">
            <?php __($this->App->dictionary('Main Bets'))?>
            <div class='toggleContainers'>
                <div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this);'><?=__('Open All')?></button></div>
                <div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this);'><?=__('Close All')?></button></div>
            </div>
        </div>
        <div class='groupsWrapLong sort'>
    
        <?php $i=0;
        foreach($data['periods'] as $period){ 
            if($overview_layout == "american"){
                echo $this->element("Sportbook/lines/desktop_detail_game_layout", array(
                    "period" => $period,
                    "i" => $i,
                    "sport" => $sport,
                    "league" => $league,
                    "formatPriceAmerican" => $formatPriceAmerican,
                    "overview_layout" => $overview_layout
                )); 
            }else{
                echo $this->element('Sportbook/lines/mobile_detail_game_layout', array(
                    "period" => $period,
                    "sport" => $sport,
                    "league" => $league,
                    "formatPriceAmerican" => $formatPriceAmerican,
                    "overview_layout" => $overview_layout,
                    "type" => "desktop"
                ));
            }
         $i++; } // fin foreach ?>
        </div>
    </div>
    <?php } // fin if period ?>
</div><!-- fin bloc game desktop -->

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
                <?php echo __($this->App->dictionary($groups['description']))?>
                <div class='toggleContainers'>
                <div class='openAll'><button type='button' class='btn btn btn-success' onclick='masiveOpenContainers(this);'><?=__('Open All')?></button></div>
                <div class='closeAll secret'><button type='button' class='btn btn btn-danger' onclick='masiveCloseContainers(this);'><?=__('Close All')?></button></div>
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
                            <div class='titleText'><?php echo __($this->App->dictionary($props['contestDescription']))?></div>
                        </div>
                        <div class='toggle-icon'></div>
                    </div>
                    <div id='<?php echo $selectionContainerId?>' class='collapse'>
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
                            <li class='addToBetslip <?php echo $colClass?>' id='propsgroupswraplong_<?php echo $contestantId?>'
                                chosenTeamID="<?php echo $prop['contestantName']?>"
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
                                <div class='selectionTable'>
                                    <div class='selectionFix'>
                                        <div class='selectionDesc' style='text-align: center;'><?php echo __($this->App->dictionary($prop['contestantName']))?></div>                                        
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



<?php } ?>



