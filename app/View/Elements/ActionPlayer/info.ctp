
<div class="principal" >

	 
	 <div class="form-inline col-sm-12 text-left reportMenu filtre">

	 <!-- <a id="btnFiltre" class='show-filtre' href="#"><span class='glyphicon glyphicon-minus-sign'></span></a>	-->
		
		  <div class="form-group col-md-12 col-sm-12">
			   <div class="form-group col-sm-3 ">
				   <label class="col-xs-4 control-label" for="subagent"><?php echo __('SubAgent');?>:</label>
				   <div class="col-xs-8 input-group">
				   <input type="text" class="form-control" id="subagent" name="subagent" />
			   </div>
			   
			   </div>
			   <div class="form-group col-sm-2">
				   <label class="col-xs-4 control-label" for="calendar2"><?php echo __('Start Date');?>:</label>
				   <div class="col-xs-8 input-group">
					  <input type="text" class="form-control datepiker text" id="calendar2" name="calendar2" style='z-index:999;' readonly/>
				   </div>
			   </div>
			   <div class="form-group col-sm-2">
				   <label class="col-xs-4 control-label" for="calendar3"><?php echo __('End Date');?>:</label>
				   <div class="col-xs-8 input-group">
					   <input type="text" class="form-control datepiker text" id="calendar3" name="calendar3" style='z-index:999;' readonly/>
					  </div>
			   </div>
		
			   <div class="form-group col-sm-2">
				   <div class=" input-group col-sm-12">
					   <span class="input-group-addon">
						   <input id="summary" class="cheked" type="checkbox" onclick="executeActionPlayer(false)" value="" name="summary">
					   </span>
					   <input class="form-control" type="text" value="Summary" disabled="">
				   </div>
			   </div>
			   
			   <div class="form-group col-sm-2">
					   <button class="btn btn-inverse active" type="button" onclick="executeActionPlayer(false);" href="#" id="btnSave">Run Report</button>
			   </div>
		  </div>
	</div>

<div class="reportContainer col-sm-12 text-right" id="actionplayerdiv" style="display:none;">
	 <button class="btn btn-inverse active" type="button" onclick="" href="#" id="btnDetailsClose"><span class="glyphicon glyphicon-minus-sign"></span> Summary</button>
	 <a id='btnDetailsOpen' href='#'><span class="glyphicon glyphicon-minus-sign"></span> <?php echo __('Open Taps');?></a>   
	 <table id="actionplayerdetail" width="98%" align="center" border="0" cellspacing="5" cellpadding="0" class="responsive-data report" ></table>
</div>
