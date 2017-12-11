<?php if(!empty($data)){?> 

        <?php
            
            $groupContainerId=$this->App->sanitiazeId('propsgroupswraplong '.$data['description']);
            
            ?>
            <div id='<?php echo $groupContainerId?>' class='group toggleContainersParent'>
            <div class='groupTitle h4'><?php echo $data['description']?></div>
            <div class='betsWrap sort'>
            <?php if(!empty($data['listGroupProp'])){?>
                <?php foreach($data['listGroupProp'] as $props){ 
                $selectionContainerId='data_'.$props['gameNum'].'_'.$this->Sportbook->sanitiazeId($props['contestType2']).'_'.$props['gameNum'].'_'.$props['contestNum'];
                ?>
                  <div id="group_contest_<?php echo $props['contestNum']?>" class="table-games bet containerForMasiveToggle" contestId="<?=$props['contestNum']?>">
                    <div class='title header collapsed' data-toggle='collapse' aria-expanded='false' href='#<?php echo $selectionContainerId?>'>
                        <div class='ellipsis'>
                            <div class='titleText'><?php echo $props['contestDescription']?></div>
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
                                $contestantId=$props['contestNum'].'_'.$prop['contestantNum'];?>
                            <li class='addToBetslip <?php echo $colClass?>' id='propsgroupswraplong_<?php echo $contestantId?>'
                                chosenTeamID="<?php echo $prop['contestantName']?>"
                                groupDescription = "<?php echo $data['description']?>"
                                betTypeis = "<?php echo $prop['betTypeis']?>"
                                betDescription = "<?php echo $props['contestDescription']?>"
                                contestNum="<?php echo $props['contestNum']?>"
                                contestantNum = "<?php echo $prop['contestantNum']?>"
                                threshold = "<?php echo $prop['thresholdLineSF']?>"
                                mainBet="<?php echo $data['mainBet']?>"
                                dec = "<?php echo $prop['decimalOdds']?>"
                                us = "<?php echo $prop['moneyLine']?>"
                                gamenum="<?php echo $props['gameNum']?>"                              
                                isfuture= "<?php echo $data['isFeatureProps']?>"
                                isParlay= "<?php echo $data['isParlay']?>"
                                isStraight= "<?php echo $data['isStraight']?>"
                                isTeaser= "<?php echo $data['isTeaser']?>"
                                sportType= "<?php echo $sport?>"                          
                                selectionid='<?php echo $contestantId?>'>
                                <div class='selectionTable' style='<?php echo ($countProps>=3?"height:40px;":"")?>'>
                                    <div class="selectionFix">
                                        <div class="selectionContent ellipsis">
                                            <div class="selectionDesc" style="text-align: center;"><?php echo $prop['contestantName']?></div>
                                            <div class="noWrap" style="text-align: center;">
                                                <span class="selectionThreshold threshold"/>&nbsp;&nbsp;<span class="selectionThreshold threshold"><?php echo $prop['thresholdLine']?></span>
                                                <span class="selectionOdds odds"/>
                                                   <?php if ($formatPriceAmerican)
                                                         echo $prop['moneyLine'];
                                                        else
                                                         echo $prop['decimalOdds'];
                                                   ?>
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </li>
                            <?php } // foreach ?>
                        </ul>
                       <?php echo $props['comments']?>
                    </div>
                </div>
                <?php } // foreach ?>
            <?php } // if ?>
            
            </div>
            </div>

<?php } ?>
