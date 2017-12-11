<nav class="nav-left">
    <ul id="menu-left" class="list-unstyled main-menu"> 
        
        <li><a id="nav-close-left" class="validationNav btn-menu item-menu-principal" type="button" href="#"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
        <li><a id="item-sub-agent" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'DashboardAdmin','action' =>'index'),true);?>" type="button"><i class="icon-home" style="font-size:1.2em;"></i></a></li>
        <li><a id="item-sub-agent" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'Sportbook','action' =>'index'),true);?>" type="button"><?php echo __('Sportbook');?></a></li>
        <li><a id="item-sub-agent" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'AgentMail','action' =>'index'),true);?>" type="button"><?php echo __('Message');?> <span class="badge badge-mail"></span></a></li>
        <!--<li><a id="item-sub-agent" class="validationNav btn-menu item-menu-principal" href="#" type="button" onclick="window.open('<?php echo $this->Html->url('/chat', true);?>','Chat','height=450,width=650');"><?php echo __('Chat');?> <span id="unread_msgs_alert_container"><small id="unread_msgs_alert" class="unread-msgs-alert"></small></span></a></li>-->
        <li><a id="item-sub-agent" class="btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'Pages','action' =>'logout'),true);?>" type="button" onclick="logout();"><?php echo __('Logout');?></a></li>
        <hr/>
        <?php if($this->App->getTypeCustomer() == 'M' || $this->App->getTypeCustomer() == 'A'){ ?>
            <?php if($this->App->it_has_permission(array('DailyFigureReport','BalanceDueReport','CustomerListReport','WeeklyBalanceReport','InterfaceReport','ActionByPlayerReport','HandleReport','OpenWagersReport','AgentPositionReport','AgentDistribution','DeletedWagersDetails'))){ ?>
            <li><a id="item-reports" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'ReportsHome','action' =>'index'),true);?>" type="button"><?php echo __('Reports');?></a></li>
             <?php } ?>
            <li><a id="item-account" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'Personal','action' =>'index'),true);?>" type="button"><?php echo __('Account');?></a></li>
            <li><a id="item-customer-list" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'CustomerList','action' =>'index'),true);?>" type="button"><?php echo __('Customer List');?></a></li>
            <?php if($this->App->it_has_permission('LineEntryAccess')){ ?>
            <li><a id="item-line-entry" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'LineEntry','action' =>'index'),true);?>" type="button"><?php echo __('Line entry');?></a></li>
            <?php } ?>
            <?php if($this->App->it_has_permission('Comments')){ ?>
            <li><a id="item-support" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'Comments','action' =>'index'),true);?>" role="button"><?php echo __('Comments');?></a></li>
            <?php } ?>
            <li><a id="item-sub-agent" class="validationNav btn-menu item-menu-principal" href="<?php echo $this->Html->url(array('controller' => 'Agent','action' =>'index'),true);?>" type="button"><?php echo __('Sub Agent');?></a></li>
        <?php } ?>
        <input name="parentID" id="parentID" type="hidden" value="pp" >
        <input name="encontroAgent" id="encontroAgent" type="hidden" value="" >
        <input name="menuID" id="menuID" type="hidden" value="" >
        <input name="pressSelectedTeaser" id="pressSelectedTeaser" type="hidden" value="N" >
        <input name="SelectedCredit" id="SelectedCredit" type="hidden" value="0" >
        <input name="SelectedMaxBet" id="SelectedMaxBet" type="hidden" value="0" >
        <input name="SelectedParlay" id="SelectedParlay" type="hidden" value="0" >
        <input name="SelectedTeaser" id="SelectedTeaser" type="hidden" value="0" >
        <input name="SelectedLive" id="SelectedLive" type="hidden" value="0" >
        <input name="SelectedLiveParlay" id="SelectedLiveParlay" type="hidden" value="0" >                                
        <input name="SelectedProp" id="SelectedProp" type="hidden" value="0" >
        <input name="SelectedSettle" id="SelectedSettle" type="hidden" value="0" >
        <input name="SelectedMinInet" id="SelectedMinInet" type="hidden" value="0" >
        <input name="SelectedMinCu" id="SelectedMinCu" type="hidden" value="0" >                                
        <input name="SelectedSelect" id="SelectedSelect" type="hidden" value="0" >
        <input name="SelectedGroup" id="SelectedGroup" type="hidden" value="Group1" >
        <input name="OcultaGroup4" id="OcultaGroup4" type="hidden" value="N" >
        <input name="totalRows" id="totalRows" type="hidden" value="0" >
        <input name="SelectedP" id="SelectedP" type="hidden" value="0" >
        <input name="SelectedC" id="SelectedC" type="hidden" value="0" >
        <input name="SelectedL" id="SelectedL" type="hidden" value="0" >
        <input name="progressBarPorcent" id="progressBarPorcent" type="hidden" value="5" >
        <input name="progressBarPorcentText" id="progressBarPorcentText" type="hidden" value="0" >
        <input name="countPlayers" id="countPlayers" type="hidden" value="0" >
    </ul>
</nav>
