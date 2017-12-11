
<div id="header">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header navbar-agent">
            <div class='wrap-select-role'>
                <select id="selectAgentRole" class="chosen-select"  data-placeholder="Choose a agent">
                    <?php
                    if(!empty($agents)){
                        echo '<option val="">Select agent</option>';
                        foreach($agents as $agent){
                            echo '<option val="'.$agent.'">'.$agent.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
           
            <div class='wrap-select-maintenance' style="z-index: 999;">
               <div class="bloc-select-navbar" style="z-index: 999;position:relative;left:0px;">
                    <select class="form-control" id="selectAgentMaintenance" name='' style="z-index: 999;">
                        <?php if($authUser["accountType"] == 'M'){ ?>
                        <option value="0"><?php echo __('SELECT');?></option>
                        <option value="1"><?php echo __('ALL PLAYERS');?></option>
                        <option value="2"><?php echo __('SPECIFIC PLAYER');?></option>
                        <option value="3"><?php echo __('All AGENTS');?></option>
                        <option value="4"><?php echo __('SPECIFIC AGENT');?></option>
                        <option value="5"><?php echo __('ALL');?></option>
                       <?php }else{ ?>
                        <option value="0"><?php echo __('SELECT');?></option>
                        <option value="1"><?php echo __('ALL PLAYERS');?></option>
                        <option value="2"><?php echo __('SPECIFIC PLAYER');?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="bloc-select-navbar" >
                    <select id="selectSpecificAgent" name='selectSpecificAgent' class="form-control chosen-select" data-placeholder="Choose"  multiple tabindex="4">
                    </select>
                </div>
                
            </div>
        </div>
        
         <div class="collapse navbar-collapse" id="myNavbar">   
            <ul id="menu-top" class="nav navbar-nav navbar-right" role="tablist">
                <li><a id='btn-roles' class="btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Roles');?></a></li>
                <li><a id='btn-maintenance' class="btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Maintenance');?></a></li>
           </ul>
        </div>
    </nav>
</div>
<div class="row header-responsive hidden">
    <div class="bloc-select-navbar">
        <select id="selectSpecificAgent" name='selectSpecificAgent' class="form-control chosen-select" data-placeholder="Choose"  multiple tabindex="4">
        </select>
    </div>
    <div class='col-sm-4'>
        <select id="selectAgentRole" class="chosen-select"  data-placeholder="Choose a agent">
            <?php
            if(!empty($agents)){
                echo '<option val="">Select agent</option>';
                foreach($agents as $agent){
                    echo '<option val="'.$agent.'">'.$agent.'</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="col-sm-8" >   
        <a id='btn-maintenance' class="btn btn-inverse btn-md dropdown-toggle pull-right" ><?php echo __('Maintenance');?></a>
        <a id='btn-roles' class="btn btn-inverse btn-md dropdown-toggle pull-right" ><?php echo __('Roles');?></a>
    </div>
</div>
<script>
    $(document).ready(function() {
         $(".chosen-select").chosen();
         $('#specificReceiver').trigger("chosen:updated");
    })
</script>
