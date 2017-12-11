<div id="header">
    <nav class="navbar navbar-inverse">
            <div class="navbar-header">

            <?php
                $user1=$this->Session->read('username'); ?>
                    <div class="wrap-input-login">
                        <ul class="nav navbar-nav">
                            <li>
                            <?php if(count($user1)>1){ ?>
                            <input type="hidden" id="webside" value="<?php if(isset($user1["InetTarget"])) echo $user1["InetTarget"] ?>">
                            <input type="hidden" id="accounttype" value="<?php if(isset($user1["Type"])) echo $user1["Type"] ?>">
                            <input type="hidden" id="parent" value="<?php if(isset($user1["Parent"])) echo $user1["Parent"] ?>">
                            <input type="hidden" id="storeown" value="<?php if(isset($user1["Store"])) echo $user1["Store"] ?>">
                            <input type="hidden" id="dbNumber" value="<?php if(isset($user1["DB"])) echo $user1["DB"] ?>">
                            <?php }else{ ?>
                            <input type="hidden" id="webside" value="">
                            <input type="hidden" id="accounttype" value="">
                            <input type="hidden" id="parent" value="">
                            <input type="hidden" id="storeown" value="">
                            <input type="hidden" id="dbNumber" value="">
                            <?php } ?>
                            </li>
                            <li></li>
                        </ul>
                    </div>
            </div>
        
            <div class="collapse navbar-collapse" id="myNavbar">   
                <?php if($this->Session->read('SectionNav') == 'account') { ?>
                <ul id="menu-top" class="nav navbar-nav navbar-right" role="tablist">
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'Personal','action' =>'index'),true);?>" class="validationNav btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Personal');?></a></li>
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'Limits','action' =>'index'),true);?>" class="validationNav btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Limits');?></a></li>
                    <?php if($this->App->it_has_permission('Promotions')){ ?>
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'Promotions','action' =>'index'),true);?>" class="validationNav btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Promotions');?></a></li>
                    <?php } ?>
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'Wagers','action' =>'index'),true);?>" class="validationNav btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Wagers');?></a></li>
                    <li><a href="<?php echo $this->Html->url(array('controller' => 'Transactions','action' =>'index'),true);?>" class="validationNav btn btn-inverse btn-md dropdown-toggle" ><?php echo __('Transaction');?></a></li>                
                </ul>
                <input name="pressedEdit" id="pressedEdit" type="hidden" value="N" >
                
               <?php } elseif($this->Session->read('SectionNav') == 'reports'){ ?>
               <!--
                <ul id="menu-top" class="nav navbar-nav navbar-right" role="tablist">
                    <li class="dropdown">
                        <a href="#" class="btn btn-inverse btn-md dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Agent <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'WeeklyBalance');">Weekly2 Balance</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'ActionPlayer');">Action By Player</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'DailyFigure');">Daily Figure</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'DeleteGameWager');">Delete Wager</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'AgentDistribution');">Agent Distribution</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'AgentPosition');">Agent Position</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'PlayerList');">Customer List</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'OpenWager');">Open Wagers</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="btn btn-inverse btn-md dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Office <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'Interface');">Interface</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'BalanceDue');">Balance Due</a></li>
                            <li><a onclick="validaNav($('#saveChangesBefore').val(),'Handle');">Handle</a></li>
                        </ul>
                    </li>
                </ul>
                -->
                <?php } ?>
            </div>
    </nav>
</div> <!-- #header -->

<div class="container-global-customer">
    
    <input value="" id="globalcustomer" maxlength="10" placeholder="Customer ID" class="form-control" type="text">
    <button class="btn btn-primary btn-small size-50" id="btn_search_customer" type="button" >
        <span class="glyphicon glyphicon-search size-50"></span>
    </button>
     <a href="<?php echo $this->Html->url(array('controller' => 'DashboardAdmin','action' =>'search'),true);?>" class="btn btn-primary btn-small size-50" id="btn_find_customer" type="button"><?php echo __('Find');?></a>
</div>
<script>
    $(document).ready(function() {
       // Autocomplete input #globalcustomer
        var availableCustomer = [
            "<?php echo $authUser['customerId']; ?>",
            <?php
            $hierachyAgent = @$_SESSION['hierachyAgent'];
            if(!empty($hierachyAgent)){
                foreach($hierachyAgent as $row)
                    echo '"'.$row['Customer'].'",';
            }?>
        ]; // fin array availableCustomer
        
        $( "#globalcustomer" ).autocomplete({
            source: availableCustomer,
            max:20,
            minLength:3
        });
        
        <?php if(!empty($globalCustomer)){ ?>
            $("#globalcustomer").val('<?php echo $globalCustomer; ?>');
            $("#btn_search_customer").trigger('click');
        <?php } ?>
    
    })
</script>
