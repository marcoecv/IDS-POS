<div id="header">
    <nav class="navbar navbar-inverse">
            <div class="navbar-header">

            <?php //$user=$this->Session->read('username');?>
                <input type="hidden" id="hiddenCustomerId" value="<?php echo $authUser['customerId']; ?>">
                <input type="hidden" id="webside" value="<?php echo $authUser['inetTarget']; ?>">
                <input type="hidden" id="accounttype" value="<?php echo $authUser['accountType']; ?>">
                <input type="hidden" id="parent" value="<?php echo $authUser['agentId']; ?>">
                <input type="hidden" id="storeown" value="<?php echo $authUser['store']; ?>">
                <input type="hidden" id="dbNumber" value="<?php  echo $authUser['db']; ?>">
            </div>
        
            <div >

                <div class="col col-md-4 col-md-offset-8 ">

                    <a href="/PvReports" style="color:#fff;">
                        <div class="col-md-6" style="padding: 0 2px;">
                            <button type="button" class="btn btn-success pull-right "
                                    style="width: 95%;height: 54px;font-size: 31px;">
                                Reportes
                        </div>
                    </a>
                    <a href="/DashboardAdmin" style="color:#fff;">
                        <div class="col-md-6" style="padding: 0 2px;">

                            <button type="button" class="btn btn-success pull-left "
                                    style="width: 96%;height: 54px;font-size: 31px;">
                                Lobby
                        </div>
                    </a>
                </div>
                
            </div>
    </nav>
</div> <!-- #header -->

<script>

</script>
