<?php ?>
<div id='wagersReport' class="panel panel-default">
    <div class='overlay'></div>
    <div class="panel-heading pannel-heading-1">
        <div class="panel-title"><?php echo __('Wagers Report'); ?></div>
    </div>
    <div class="panel-body">
        <div class='wagerReportTypeSelector margin-bottom'>
            <button class="btn btn-primary btn-sm" type="button" id='loadPendings' ><?php echo __('Pendings'); ?></button>
            <button class="btn btn-primary btn-sm" type="button" id='loadGraded'><?php echo __('Graded'); ?></button>
            <button class="btn btn-primary btn-sm" type="button" id='loadOpenBets'><?php echo __('Open Bets'); ?></button>
        </div>

        <div id="wpr_accordion">
            
        </div>
    </div>
</div>