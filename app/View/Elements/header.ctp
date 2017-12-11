<?php
?>
<div id="navbar-principal" class="navbar navbar-fixed-top navbar-custom" role="navigation">
    <div class="navbar-header">
        <div class='btn-bar-wrap'>
            <button class="btn btn-primary pull-right visible-xs" type="button" data-toggle="collapse"
                    data-target="#navbar">
                <span class="glyphicon glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div id="navbar" class="collapse navbar-collapse  navbar-right">
        <ul class="nav navbar-nav">
            <li>
                <a onclick="validaNav($('#saveChangesBefore').val(),'Sportbook');">
                    <div>
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                        <?php echo Functions::translate("Sportbook") ?>
                    </div>
                </a>
            </li>
            <li>
                <a onclick="validaNav($('#saveChangesBefore').val(),'#');">
                    <div>
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        <?php echo Functions::translate("Chat") ?>
                    </div>
                </a>
            </li>
            <li class="active">
                <a onkeypress="validaNav($('#saveChangesBefore').val(),'Personal');">
                    <div><?php echo Functions::translate("Admin") ?></div>
                </a>
            </li>
            <li>
                <a onclick="validaNav($('#saveChangesBefore').val(),'#');">
                    <div>
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        <?php echo Functions::translate("Logout") ?>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
