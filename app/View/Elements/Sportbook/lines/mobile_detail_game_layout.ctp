<?php
if(!empty($period['homeTeam']['spread']) && !empty($period['awayTeam']['spread']) ) 
    echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['spread'], $period['awayTeam']['spread'], null, true, 'spread', null, $sport, $league, $formatPriceAmerican, $overview_layout,$type);

if(!empty($period['homeTeam']['moneyLine']) && !empty($period['awayTeam']['moneyLine']) )
    echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['moneyLine'], $period['awayTeam']['moneyLine'], $period['draw']['moneyLine'], false, 'moneyLine', null, $sport, $league, $formatPriceAmerican, $overview_layout,$type);

if(!empty($period['homeTeam']['total']) && !empty($period['awayTeam']['total']) )
    echo $this->Sportbook->addMainBetsGroups($period, $period['awayTeam']['total'], $period['homeTeam']['total'], null, false, 'total', null, $sport, $league, $formatPriceAmerican, $overview_layout,$type);

if(!empty($period['homeTeam']['totalTeamOver']) && !empty($period['homeTeam']['totalTeamUnder']) )
    echo $this->Sportbook->addMainBetsGroups($period, $period['homeTeam']['totalTeamOver'], $period['homeTeam']['totalTeamUnder'], null, false, 'teamTotal','homeTeam', $sport, $league, $formatPriceAmerican, $overview_layout,$type);

if(!empty($period['awayTeam']['totalTeamOver']) && !empty($period['awayTeam']['totalTeamUnder']) )
    echo $this->Sportbook->addMainBetsGroups($period, $period['awayTeam']['totalTeamOver'], $period['awayTeam']['totalTeamUnder'], null, false, 'teamTotal','awayTeam', $sport, $league, $formatPriceAmerican, $overview_layout,$type);
?>