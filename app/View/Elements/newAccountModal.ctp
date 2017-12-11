<div class="modal" id="chooseTypeNewAccountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 815px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo __("Request New Account");?></h4>
            </div>
            <div class="modal-body">
                <h4><?php echo __("Account Type");?> :</h4>
                <button id='newRolRequestAgent' type='button' class='btn btn-success col-sm-12'><?php echo __("Request New Sub Agent");?></button>
                <button id='newRolRequestPlayer' type='button' class='btn btn-success col-sm-12'><?php echo __("Request New Player");?></button>
            </div>
            <div class="modal-footer"></div>
           
        </div>
    </div>
</div>
<!--END MODAL FADE-->
<div class="modal" id="newAccountAgentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 815px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">New Account</h4>
            </div>
            <div class="modal-body">
                
                <div id='newAgentWrap'>
                     <form id="newAccountAgent" action="#" role="form" class="form-inline" method="post">
                         <div>
                            <label for="newAccount_agent_subagent" class="control-label "><?php echo __("Sub Agent");?></label>
                            <input type="text" id="newAccount_agent_subagent" name="newAccount_agent_subagent" class="form-control" value="" />
                        </div>
                         <div>
                            <label for="newAccount_agent_password" class="control-label "><?php echo __("Password");?></label>
                            <input type="text" id="newAccount_agent_password" name="newAccount_agent_password" class="form-control" value="" />
                        </div>
                        <div>
                            <label for="newAccount_agent_commission" class="control-label"><?php echo __("Commission");?></label>
                            <input type="text" id="newAccount_agent_commission" name="newAccount_agent_commission" class="form-control" value="" />
                        </div>
                         
                        <h5><?php echo __("Allow Sub Agent to");?>:</h5>
                        <button id="allSelectNewRol" type="button" class="btn btn-success col-sm-12">Full permission</button>
                       
                        <div class="col-sm-12 col-xs-12">
                        <?php
                        
                        $sections = array();
                        $html = '';
                        $roles = $this->App->getAdminRoles();
                       
                        foreach($roles as $key=>$row){
                            
                            $section = trim($row['Section']);
                            if(!in_array($section,$sections)){
                                $sections[] = $section;
                                
                                $html .= '<div id="newRol'.$section.'" class="col-sm-12 col-xs-12">';
                                $html .= '<div class="col-sm-12 col-xs-12 input-group">';
                                $html .= '<input class="form-control" type="text" class="" value="'.$section.'" readonly />';
                                $html .= '<span class="input-group-addon">';
                                $html .= '<input class="selectAll" name="selectAll'.$section.'" type="checkbox" />';
                                $html .= '</span>';
                                $html .= '</div>';
                        
                                foreach($roles as $key2=>$row2){
                                   if(trim($row2['Section']) == $section){
                                        $html .= '<div class="col-md-3 col-sm-3 col-xs-2">';
                                            $html .= '<div class="checkbox checkbox-success">';
                                                 $html .= '<input type="checkbox" class="newRol" id="newRol'.$row2['RolID'].'" data-name="'.$row2['RolName'].'">';
                                                $html .= '<label for="newRol'.$row2['RolID'].'"> '.$row2['RolName'].' </label>';
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    }
                                }
                                $html .= '</div>';
                            }
                        }
                        echo $html;
                      
                        ?>
                        </div>
                     </form>
                </div>
                
            </div>
            <div class="modal-footer">
                <div class='error col-md-12'></div>
                <div class="modal-footer-btn-wrap">
                <button id="cancelNewAccountAgent" name="cancelNewAccount" type="button" data-dismiss="modal" class="btn btn-danger">
                    Cancel
                </button>
                <button id="saveNewAccountAgent" name="saveNewAccount" type="button" class="btn btn-success">
                    Save
                </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL FADE-->

<div class="modal" id="newAccountPlayerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 815px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">New Account</h4>
            </div>
            <div class="modal-body col-md-12">
                <div id='newPlayerWrap'>
                    <form id="newAccountPlayer" action="#" role="form" class="form-inline " method="post">
                        <div class="form-group col-md-12 form-horizontal">
                            <label for="numberOfAccounts" class="col-md-8 control-label"><?php echo __('Number of accounts to create');?></label>
                             <div class="col-md-4">
                            <select id='numberOfAccounts' class="col-md-12 form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                             </div>
                        </div>
                        <div id="blocAccounts" class="col-md-12"></div>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class='error'></div>
                <div class="modal-footer-btn-wrap">
                <button id="cancelNewAccountPlayer" name="cancelNewAccountPlayer" type="button" data-dismiss="modal" class="btn btn-danger">
                    Cancel
                </button>
                <button id="saveNewAccountPlayer" name="saveNewAccountPlayer" type="button" class="btn btn-success">
                    Save
                </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL FADE-->
<script>
    $(document).ready(function() {
        
        $('#newRolRequestAgent').bind('click', function(){
            $("#chooseTypeNewAccountModal").modal("toggle");
            $("#newAccountAgentModal").modal("toggle");
        });
        
        $('#newRolRequestPlayer').bind('click', function(){
            $("#chooseTypeNewAccountModal").modal("toggle");
            $("#numberOfAccounts option[value='1']").prop('selected', true);
            $('#numberOfAccounts').trigger('change');
            $("#newAccountPlayerModal").modal("toggle");
           
        });
       
        $('.selectAll').unbind('change');
        $('.selectAll').bind('change', function(){
            var parent = $(this).parents().eq(2);
            if ($(this).prop('checked') == true){
                $(parent).find('.newRol').prop('checked', true);
            }
            else{
                $(parent).find('.newRol').prop('checked', false);
            }
        });
        
        $('#allSelectNewRol').unbind('click');
        $('#allSelectNewRol').bind('click', function(){
            $('#newAgentWrap .newRol').prop('checked', true);
        });
        
        
        $('#numberOfAccounts').unbind('change');
        $('#numberOfAccounts').bind('change', function(){
           var num = parseInt($("#numberOfAccounts option:selected").val());
            var html = '';
            for(var i = 0 ; i < num; i++){
        
                html += '<div class="blocAccount col-md-12">'+
                    '<div class="form-group col-md-12">'+
                        '<label for="newAccount_player_'+i+'_password" class="col-md-4 control-label"><?php echo __('Password');?>*</label>'+
                        '<div class="col-md-8">'+
                            '<input type="text" class="form-control" id="newAccount_player_'+i+'_password" placeholder="Password" "required">'+
                       '</div>'+
                    '</div>'+
                     '<div class="form-group col-md-12">'+
                        '<label for="newAccount_player_'+i+'_creditLimit" class="col-md-4 control-label"><?php echo __('Credit Limit');?>*</label>'+
                        '<div class="col-md-8">'+
                            '<input type="text" class="form-control" id="newAccount_player_'+i+'_creditlimit" placeholder="Credit Limit" "required">'+
                        '</div>'+
                    '</div>'+
                      '<div class="form-group col-md-12">'+
                        '<label for="newAccount_player_'+i+'_betQuickLimit" class="col-md-4 control-label"><?php echo __('Bet Quick Limit');?>*</label>'+
                        '<div class="col-md-8">'+
                            '<input type="text" class="form-control" id="newAccount_player_'+i+'_betQuickLimit" placeholder="Wager" "required">'+
                        '</div>'+
                    '</div>'+
                       '<div class="form-group col-md-12">'+
                        '<label for="newAccount_player_'+i+'_settleFigure" class="col-md-4 control-label"><?php echo __('Settle Figure');?></label>'+
                        '<div class="col-md-8">'+
                            '<input type="text" class="form-control" id="newAccount_player_'+i+'_settleFigure" placeholder="Optional">'+
                        '</div>'+
                    '</div>'+
                       
                       '<div class="form-group col-md-12">'+
                        '<label for="newAccount_player_'+i+'_agent" class="col-md-4 control-label"><?php echo __('Agent');?></label>'+
                        '<div class="col-md-8">'+
                            '<select id="newAccount_player_'+i+'_agent" class="col-md-12 form-control">'+
                               <?php foreach($this->App->getSubAgents() as $row){ ?>
                                    '<option value="<?php echo trim($row['AgentID']); ?>"><?php echo trim($row['AgentID']); ?></option>'+
                                <?php } ?>
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>';
            }
           
            $('#blocAccounts').html(html);
            var height = $('#newAccountPlayerModal .modal-dialog').height();
            $('#newAccountPlayerModal .modal-backdrop').height(height + 300);
           
        });
        
    /******************************** Saving *********************************/
        $('#saveNewAccountPlayer').unbind('click');
        $('#saveNewAccountPlayer').bind('click', function(){
            $('#newAccountPlayerModal .error').html("");
            var dataRequest = [];
            var accounts = $('#newAccountPlayer .blocAccount');
            var num = $('#newAccountPlayer .blocAccount').length;
            
            for (var i=0; i< num; i++){
                var account = accounts.eq(i);
                var data = {
                    'password': account.find('#newAccount_player_'+i+'_password').val(),
                    'creditLimit': account.find('#newAccount_player_'+i+'_creditlimit').val(),
                    'betQuickLimit': account.find('#newAccount_player_'+i+'_betQuickLimit').val(),
                    'settleFigure': account.find('#newAccount_player_'+i+'_settleFigure').val(),
                    'agent': account.find('#newAccount_player_'+i+'_agent option:selected').val()
                }
                if(validationNewAccount(data, 'P')){
                    dataRequest[i] = data;
                }else{
                    $('#newAccountPlayerModal .error').html("<?php echo __('Error during validating your request. Revise your data'); ?>");
                }
            }
            
            if (isIsset(dataRequest)) {
                sendRequestNewAccount(dataRequest,'P');
            }
            
        })
        
        $('#saveNewAccountAgent').unbind('click');
        $('#saveNewAccountAgent').bind('click', function(){
            var dataRequest = [];
            var rols = $('#newAccountAgent .checkbox input:checked');
            var nameRols = [];
            if (rols.length != 0) {
                var i=0;
                for(var rol in rols){
                    var dataName = rols.eq(rol).attr('data-name')
                    if (dataName != undefined) {
                        nameRols[i] = rols.eq(rol).attr('data-name');
                        i++;
                    }
                }
            }
            var data = {
                'subagent' : $('#newAccount_agent_subagent').val(),
                'password' : $('#newAccount_agent_password').val(),
                'commission' : $('#newAccount_agent_commission').val(),
                'rols' : JSON.stringify(nameRols)
            }
             
            if(validationNewAccount(data, 'A')){
                dataRequest = data;
            }else{
                $('#newAccountAgentModal .error').html("<?php echo __('Error during validating your request. Revise your data'); ?>");
            }
                
            if (isIsset(dataRequest)) {
                sendRequestNewAccount(dataRequest,'A');
            }
        })
       
    });
</script>

