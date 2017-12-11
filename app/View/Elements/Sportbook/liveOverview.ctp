<div class="panel panel-default live-overview-wrapper">
    <div class="panel-heading pannel-heading-1">
        <div class="panel-title"><?= __("NOW IN PLAY") ?></div>
    </div>
    <div class="body panel panel-default">
        <?php if(sizeof($sports) == 0): ?>
            <?= __("There is no in play games yet") ?>
        <?php endif; foreach($sports as $sport => $games): ?>
            <div class="sport-heading panel-heading pannel-heading-1">
                <div class="panel-title">
                    <div class="iconWrap">
                        <div class="iconSport white <?= strtolower($sport) ?>"></div>
                    </div>
                    <div class="sport-name">
                        <?= strtoupper($this->App->dictionary($sport)) ?>
                    </div>                    
                </div>
            </div>
            <div class="sport-body">
                <?php foreach($games as $game) : 
                    
                    $game["Time"] .= "'";
                    if($sport == "Tennis"){
                        $game["Time"] = "";
                    }else if($sport == "Baseball"){
                        $game["Time"] = $game["Possesion"] == 1 ? __("Top") : __("Bottom");
                    }
                    ?>
                    <div class="game">
                        <div class="score">
                            <div class="away">
                                <?= $game["ScoreAway"] ?>
                            </div>
                            <div class="home">
                                <?= $game["ScoreHome"] ?>
                            </div>
                        </div>
                        <div class="teams">
                            <div class="away">
                                <?= $game["Team1ID"] ?>
                            </div>
                            <div class="home">
                                <?= $game["Team2ID"] ?>
                            </div>
                        </div>
                        <div class="other-info">
                            <div class="period-description">
                                <?= $this->App->dictionary($game["PeriodDescription"]) ?>
                            </div>
                            <div class="time">
                                <?= $game["Time"] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>