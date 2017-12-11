<div class="container-fluid" id="status">
    <div class="col-sm-12 col-xs-12  text-center wrap-status">
        <?php if($rolStatus['PreGame']){ ?>
        <div class='inline-block'>
            <div class="btn-group btn-custom">
                 <input id="ckPregame" type="checkbox" class="style3 bloquear changed"/> <span class="label-status"><?php echo __('Pre-game');?></span>
            </div>
        </div>
        <?php } ?>
        <?php if($rolStatus['Live']){ ?>
        <div class='inline-block'>
            <div class=" btn-group btn-custom">
                <input id="ckLive_Betting" type="checkbox" class="style3 bloquear changed"/>  <span class="label-status"><?php echo __('Live Betting');?></span>
            </div>
        </div>
        <?php } ?>
        <?php if($rolStatus['Casino']){ ?>
        <div class='inline-block'>
            <div class=" btn-group btn-custom">
                <input id="ckCasino" type="checkbox" class="style3 bloquear changed"/> <span class="label-status"><?php echo __('Casino');?></span>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
        



