<?php
?>
<div id="reports">
    <div id='accountHistoryReport' class="panel panel-default">
        <div class='overlay'></div>
        <div class="panel-heading pannel-heading-1">
            <div class="panel-title"><?php echo __('Account History Report');?></div>
        </div>
        <div class="panel-body">
            <div class='wagerReportTypeSelector margin-bottom'>
                <button class="btn btn-success btn-sm" type="button" id='ahr_all' ><?php echo __('All');?></button>
                <button class="btn btn-primary btn-sm" type="button" id='ahr_freePlays'><?php echo __('Free Plays');?></button>
            </div>
        </div>
    </div>
    
    <div id="ahr_headerTableDiv">
        <table id="ahr_headerTable" class="responsive-data report table table-striped table-bordered">
            <tr>
                <th class="ahr_docNumth cell-data"><?php echo __('Document#');?></th>
                <th class="ahr_dateth cell-data hide-data"><?php echo __('Date');?></th>
                <th class="ahr_descth cell-data hide-data"><?php echo __('Description');?></th>
                <th class="ahr_amountth cell-data"><?php echo __('Amount');?></th>
                <th class="ahr_balanceth cell-data"><?php echo __('Balance');?></th>
                <th class="ahr_wagerDetailsth cell-data hide-data"><?php echo __('Details');?></th>
            </tr>
        </table>
    </div>
    <div id="ahr_tableDiv">
        <table id="ahr_Table" class="responsive-data report table table-striped table-bordered"></table>
    </div>
</div>