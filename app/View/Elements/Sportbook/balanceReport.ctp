<?php
?>
<div id='balanceReport' class="panel panel-default">
    <div class='overlay'></div>
    <div class="panel-heading pannel-heading-1">
        <div class="panel-title"><?php echo __('Daily Week Balance');?></div>
    </div>
    <div class="panel-body">
        <div id="reports">
            <div class="wagerReportTypeSelector form-group col-sm-3">
                <label class="col-xs-4 control-label" for="masteragentId"><?php echo __('Period');?>:</label>
                <div class="col-xs-8 input-group">
                    <select class="form-control" id="br_dateFilter">
                        <option value="1"><?php echo __('This Week');?></option>
                        <option value="2"><?php echo __('Last Week');?></option>
                        <option value="3"><?php echo __('3 Week Ago');?></option>
                        <option value="4"><?php echo __('4 Week Ago');?></option>
                    </select>
                </div>
            </div>
            
            <div class="wagerReportTypeSelector form-group col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input id="br_startDaySelector" class="checkbox-inline" type="checkbox" value="1" name="br_startDaySelector">
                    </span>
                    <input class="form-control" type="text" value="<?php echo __('Start From Tuesday');?>" disabled="">
                </div>
            </div>
            <div id="br_headerTableDiv">
                <table id="br_headerTable" class="responsive-data report table table-striped table-bordered">
                    <thead>
                        <tr class="show-data">
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Monday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Tuesday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Wednesday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Thursday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Friday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Saturday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Sunday');?></th>
                            <th class="cell-data hidden-xs hidden-sm show-data"><?php echo __('Total');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="show-data">
                            <td data-th='Monday' class="cell-data show-data">0</td>
                            <td data-th='Tuesday' class="cell-data show-data">0</td>
                            <td data-th='Wednesday' class="cell-data show-data">0</td>
                            <td data-th='Thursday' class="cell-data show-data">0</td>
                            <td data-th='Friday' class="cell-data show-data">0</td>
                            <td data-th='Saturday' class="cell-data show-data">0</td>
                            <td data-th='Sunday' class="cell-data show-data">0</td>
                            <td data-th='Total' class="cell-data show-data">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <input type="hidden" id="br_selectedInitDate" value=""/>
                   
            <div id="br_accordion">
                
            </div>
        </div>
    </div>
</div>