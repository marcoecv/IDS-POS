<?php
function sanitiazeID($id){
	$id=str_replace(" ", "_", $id);
	return $id;
}
?>
<div class="modal fade" id="teaserSelectorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="modal-title"><?php echo __('Select Teaser'); ?></span>
			</div>
			<div class="modal-body">
				<?php
				//var_dump($teasers);
				foreach($teasers as $teaser){
					if(empty($teaser['TeaserName'])){
						continue;
					}
					$teaserInfoID=sanitiazeID("teaserInfo_".$teaser['TeaserName']);
					?>
					<div class='teaser panel panel-default'>
						<div class='name panel-heading pannel-heading-2'>
							<table class="tableTeaserSelector">
								<tr>
									<td class='TeaserNameWrap' href='#<?php echo $teaserInfoID?>' data-toggle='collapse' aria-expanded="false">
										<?php echo str_replace("+", " ", $teaser['TeaserName'])?>
									</td>
									<td class='showTeaserInfoWrap'>
										<button type="button" class="btn btn-sm btn-info showTeaserInfo" href='#<?php echo $teaserInfoID?>' data-toggle='collapse' aria-expanded="false">
											<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>									
										</button>
									</td>
									<td class='selectTeaserButtonWrap'>
										<button type="button" class="btn btn-sm btn-success selectTeaser" teaserName='<?php echo $teaser['TeaserName']?>' data-dismiss="modal">
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</button>
									</td>
								</tr>
							</table>
						</div>
						<div class='panel-body panel-collapse collapse teaserInfoPanelBody' id='<?php echo $teaserInfoID?>'>
							<div class='padding'>
								<ul>
									<?php
									foreach($teaser['SportTypes'] as $SportType =>$SportTypeConfig){
										?>
										<li class='description'>
											<?php echo $SportType.": ";?>
											<ul>
												<?php
												foreach($SportTypeConfig as $betType => $betTypeConfig){
													?>
													<li class='description'>
														<?php
														$betTypeLable="";
														if($betType=="L") $betTypeLable='Total';
														if($betType=="S") $betTypeLable='Spread';

														echo $betTypeLable.": ";
														$coma=false;
														foreach($betTypeConfig as $SportSubType => $points){
															echo ($coma?", ":"")."{$SportSubType}:{$points}pts";
															$coma=true;
														}
														?>
													</li>
													<?php
												}
												?>
											</ul>
										</li>
										<?php
									}
									?>
									<li class='description'>
										Ties:
										<?php 	
										if($teaser['TeaserTies']==0)
											echo "Push";
										if($teaser['TeaserTies']==1)
											echo "Win";
										if($teaser['TeaserTies']==2)
											echo "Lose";
										?>
									</li>
									<li class='description'>
										Pay Card:
										<?php
										$coma=false;
										foreach($teaser['PayCard'] as $PayCard){
											$num=floatval($PayCard['MoneyLine']);
											$dec=floatval($PayCard['ToBase']);
											$odds=$num>$dec? round($num/$dec*100, 0) : -round($dec/$num*100, 0);
											echo ($coma?", ":"")."{$PayCard['GamesWon']}/{$PayCard['GamesPicked']}: {$odds}";
											$coma=true;
										}
										?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
				}
				if(empty($teasers)){
					echo "No Teaser Available.";
				}
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
			</div>
		</div>
	</div>
</div>