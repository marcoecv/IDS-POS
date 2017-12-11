<div class='col-xs-12 line-entry-line-container flip-container' id="line-entry-line-container" ontouchstart="this.classList.toggle('hover');" onclick="window.location='/LineEntry'">
    <div class="flipper">
        <div class="front">
            <div class='col-xs-12 line-entry-line-header'>
                <div class="line-entry-header-sport">
                    <div class="iconSport <?php echo strtolower($data['SportType']); ?>"></div>
                    <span>
                        <?php echo $data['Team1ID']; ?>
                    vs
                        <?php echo $data['Team2ID']; ?>
                    </span>
                </div>
            </div>
            <div class='col-xs-12 line-entry-line-body'>
                <div class="col-xs-12 line-entry-meta-data">
                    <span class='Date'><?php echo $this->App->formatedDateChat($data['GameDateTime']); ?></span>
                </div>
                <div class="col-xs-12 line-entry-meta-data">
                    <span><b><?php echo $data['SportType'].'</b> - <i>'.$data['SubSport']; ?></i></span>            
                </div>
                <span class='linked-store-flag <?php echo $data['LinkedToStoreFlag']; ?>'><strong><?php echo $data['LinkedToStoreFlag']; ?></strong></span>
            </div>
            <div style="clear:both;"></div>
            <div class="table-responsive" id="tableLineEntriesBack">
                <table class="table" style="font-size: 8px;margin-bottom: 0px;">
                    <tr style="margin-bottom: 0px;">
                        <td >&nbsp;</td>
                        <td >S</td>
                        <td >ML</td>
                        <td >T</td>
                        <td >TT<label class="over-label" style="font-size: 8px;">O</label><label class="under-label" style="font-size: 8px;">U</label></td>
                    </tr>
                    <tr style="margin-bottom: 0px;">
                        <td >T1</td>
                        <td ><?= $data['Spread1']." ".$data['SpreadAdj1'] ?></td>
                        <td ><?= $data['MoneyLine1'] ?></td>
                        <td >O <?= $data['TotalPoints']." ".$data['TtlPtsAdj1'] ?></td>
                        <td ><?= $data['Team1TotalPoints']." ".$data['Team1TtlPtsAdj1'].$data['Team1TotalPoints']." ".$data['Team1TtlPtsAdj2'] ?></td>
                    </tr>
                    <tr style="margin-bottom: 0px;">
                        <td >T2</td>
                        <td ><?= $data['Spread2']." ".$data['SpreadAdj2'] ?></td>
                        <td ><?= $data['MoneyLine2'] ?></td>
                        <td >O <?= $data['TotalPoints']." ".$data['TtlPtsAdj2'] ?></td>
                        <td ><?= $data['Team2TotalPoints']." ".$data['Team1TtlPtsAdj2']."&nbsp;".$data['Team2TotalPoints']." ".$data['Team2TtlPtsAdj2'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="back line-metadata-line-entry col-xs-12">
            <div class="col-xs-12">
                <div class="col-xs-1"></div>
                <div class="col-xs-3">S</div>
                <div class="col-xs-1">ML</div>
                <div class="col-xs-3">T</div>
                <div class="col-xs-4"><label class="over-label">O</label>TT<label class="under-label">U</label></div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-1">T1</div>
                <div class="col-xs-3"><?= $data['Spread1']." ".$data['SpreadAdj1'] ?></div>
                <div class="col-xs-1"><?= $data['MoneyLine1'] ?></div>
                <div class="col-xs-3">O <?= $data['TotalPoints']." ".$data['TtlPtsAdj1'] ?></div>
                <div class="col-xs-4"><?= $data['Team1TotalPoints']." ".$data['Team1TtlPtsAdj1']."&nbsp;&nbsp;&nbsp;".$data['Team1TotalPoints']." ".$data['Team1TtlPtsAdj2'] ?></div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-1">T2</div>
                <div class="col-xs-3"><?= $data['Spread2']." ".$data['SpreadAdj2'] ?></div>
                <div class="col-xs-1"><?= $data['MoneyLine2'] ?></div>
                <div class="col-xs-3">U <?= $data['TotalPoints']." ".$data['TtlPtsAdj2'] ?></div>
                <div class="col-xs-4"><?= $data['Team2TotalPoints']." ".$data['Team2TtlPtsAdj1']."&nbsp;&nbsp;&nbsp;".$data['Team2TotalPoints']." ".$data['Team2TtlPtsAdj2'] ?></div>
            </div>
        </div>
    </div>
</div>