
<nav class="nav-right">
    <?php if($this->Session->read('SectionNav') == 'account') { ?>
    <ul id="menu-right" class="list-unstyled main-menu">
        <li><a id="nav-close-right" class="btn-menu" type="button" href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
            <li><a id='lnk-Personal' href="#" onclick="validaNav($('#saveChangesBefore').val(),'Personal');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Personal</a></li>
            <li><a id='lnk-Limits' href="#" onclick="validaNav($('#saveChangesBefore').val(),'Limits');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Limits</a></li>
            <li><a id='lnk-Promotions' href="#" onclick="validaNav($('#saveChangesBefore').val(),'Promotions');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Promotions</a></li>
            <li><a id='lnk-Wagers' href="#" onclick="validaNav($('#saveChangesBefore').val(),'Wagers');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Wagers</a></li>
            <li><a id='lnk-Transactions' href="#" onclick="validaNav($('#saveChangesBefore').val(),'Transactions');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Transaction</a></li>
        </ul>
        <?php }else if($this->Session->read('SectionNav') == 'reports'){ ?>
       
        <ul id="menu-right" class="list-unstyled main-menu">
            <li><a id="nav-close-right" class="btn-menu" type="button" href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
            <li><a id='lnk-AgentDistribution' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/agent_distribution');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Agent Distribution</a></li>
            <li><a id='lnk-AgentPosition' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/agent_position');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Agent Position</a></li>
            <li><a id='lnk-PlayerList' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/player_list');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Customer List</a></li>
            <li><a id='lnk-WeeklyBalance' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/weekly_balance');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Weekly Balance</a></li>
            <li><a id='lnk-ActionPlayer' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/action_by_player');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Action By Player</a></li>
            <li><a id='lnk-DailyFigure' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/daily_figure');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Daily Figure</a></li>
            <li><a id='lnk-DeleteGameWager' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/delete_wager');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Delete Wager</a></li>
            <li><a id='lnk-Interface' href="#" onclick="validaNav($('#saveChangesBefore').val(),'OfficeReports/interface_report');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Interface</a></li>
            <li><a id='lnk-OpenWager' href="#" onclick="validaNav($('#saveChangesBefore').val(),'AgentReports/open_wagers');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Open Wagers</a></li>
            <li><a id='lnk-BalanceDue' href="#" onclick="validaNav($('#saveChangesBefore').val(),'OfficeReports/balance_due');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Balance Due</a></li>
            <li><a id='lnk-Handle' href="#" onclick="validaNav($('#saveChangesBefore').val(),'OfficeReports/handle');" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Handle</a></li>
    </ul>
        
        <?php }else if($this->Session->read('SectionNav') == 'agent'){ ?>
       
        <ul id="menu-right" class="list-unstyled main-menu">
            <li><a id="nav-close-right" class="btn-menu" type="button" href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
            <li><a href="#" onclick="$('#btn-roles').trigger('click')" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Roles</a></li>
            <li><a href="#" onclick="$('#btn-maintenance').trigger('click')" class="btn-menu btn btn-inverse btn-md dropdown-toggle" >Maintenance</a></li>
        </ul>
         <?php 
         }else{ } ?>
</nav>

<form name="frmLinks" id="frmLinks" method="post" action="" target="_blank">
    <input type="hidden" name="customerURL" id="hiddenCustomerUrl" value="" />
    <input type="hidden" name="password" id="hiddenPasswordCustomer" value="" />
    <input type="hidden" name="submit1" id="hiddenSubmit1" value="Login" />
    <input type="hidden" name="strPageRedirect" id="strPageRedirect" value="" />
</form>

<script>
    $(document).ready(function(){
        var pageCurrent = "<?php echo $this->params['controller']; ?>";
        $('.btn-menu').removeClass('active');
        $('#lnk-'+pageCurrent).addClass('active');
    });
</script>


