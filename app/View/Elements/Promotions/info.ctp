<div class="container-fluid" id="promotions">
    
    <div class="col-sm-6">
        <h4><?php echo __('Line Discount');?></h4>
         <form class="form-horizontal">
             <div class="form-group">
                 <div class="col-sm-6 col-xs-12 ">
                    <label class="col-sm-6 col-xs-5 control-label" for="pass"><?php echo __('% Phone');?></label>
                    <div class=" col-sm-6 col-xs-7">
                        <input TYPE="text" id="puntil" class="form-control text bloquear customerlist changed" maxlength="3" value="" >
                    </div>
                 </div>
 
                <div class="col-sm-6 col-xs-12">
                    <div class=" input-group col-sm-12 col-xs-12">

                        <input type="text" class="form-control datepicker text bloquear changed" id="calendaruntil" placeholder="<?php echo __('Expiration Date');?>" style="border-radius:4px;z-index:999;">
                    </div>
                 </div>
            </div>
        </form>
        
        <form class="form-horizontal">
             <div class="form-group">
                 <div class="col-sm-6 col-xs-12 ">
                    <label class="col-sm-6 col-xs-5 control-label" for="pass"><?php echo __('% Inet');?></label>
                    <div class=" col-sm-6 col-xs-7">
                       <input type="text" class="form-control text bloquear changed" id="inetuntil" value="" maxlength="2" onkeypress=" return validate(event);">
                    </div>
                </div>
        
                <div class="col-sm-6 col-xs-12">
                    <div class=" input-group col-sm-12 col-xs-12">

                        <input type="text" class="form-control datepicker text bloquear changed" id="calendarinet" style="border-radius:4px;z-index:999;" placeholder="<?php echo __('Expiration Date');?>" style="">
                    </div>
                 </div>
            </div>
        </form>
    </div>
    
    <div class="col-sm-6 col-xs-12">
        <h4> Free Half Pts</h4>
        <form class="form-inline col-sm-6">
            <div class=" input-group col-sm-12">
                <span class="input-group-addon">
                    <input  name="" type="checkbox" value="" id="frehalfpfb" class=" bloquear cheked changed">
                </span>
                <input class="form-control" type="text" class="cheked" value="Phone FB" readonly >
            </div> 
        </form>
            
        <div class="form-inline col-sm-6">
            <div class=" input-group col-sm-12">
                <span class="input-group-addon">
                    <input  name="" type="checkbox" value="" id="freintefb" class=" bloquear cheked"> 
                </span>
                <input class="form-control" type="text" class="cheked" value="Internet FB" readonly >
            </div>
        </div> 
        
        <div class="form-inline col-sm-6">
            <div class=" input-group col-sm-12">
                <span class="input-group-addon">
                    <input  name="" type="checkbox" value="" id="freeintetbk" class=" bloquear cheked changed">
                </span>
                <input class="form-control" type="text" class="cheked" value="Internet BK" readonly >
            </div> 
        </div>
            
        <div class="form-inline col-sm-6">
            
            <div class=" input-group col-sm-12">
                <span class="input-group-addon">
                    <input  name="" type="checkbox" value="" id="freephonebk" class="bloquear cheked changed" />
                </span>
                <input class="form-control" type="text" class="cheked" value="Phone BK" readonly >
            </div>
        </div>

         <div class="form-inline col-sm-6 ">
             <div class="form-group col-sm-12"  style="padding: 0;">
                <div class=" input-group col-sm-12 col-xs-12">
                    <input type="text" id="expfreepts" class="form-control datepicker bloquear text" placeholder="<?php echo __('Expiration Date');?>" style="border-radius:4px; z-index: 999"/>
                </div>
            </div>
        </div>
            
        <div class="form-inline col-sm-6 ">
            <div class="form-group col-sm-12" style="padding: 0;">
                <div class=" input-group col-sm-12 col-xs-12">
                    <input type="text" id="upto5" placeholder="Up to $" maxlength="9" onkeypress=" return validate(event);" value="" class="form-control bloquear text"  style="border-radius:4px;z-index:999;" /> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12 container btn-controls">
        <div>
            <a class="btn btn-save" onclick="event.preventDefault();globalMasterSave()" href="#" id="btnSave"><?php echo __('Save');?><i class='awesome-icon-ok'></i></a>
        </div>
    </div>  
</div>
            



