<div id="footer">
    <div class="clear"></div>
<?php 
  $salida= $this->here; 
  if(trim(str_replace("/index.php/","",$salida))!="Performances" &&
     trim(str_replace("/index.php/","",$salida))!="/CustomerList" &&
     trim(str_replace("/index.php/","",$salida))!="Transactions"  &&
     trim(str_replace("/index.php/","",$salida))!="Shade"){
  ?>
        
        <div class="btn-controls" style="align:right;">
            <div class="btn-group btn-group-justified" >
                <!-- <a class="btn btn-edit" onclick="activador()" href="#">Edit</a> -->
                <!-- <a class="btn btn-cancel" onclick="cancel();" href="#">Cancel</a> -->
                <a class="btn btn-save btn-custom-large" onclick="event.preventDefault();globalMasterSave()" href="#" id="btnSave"><?php echo __('Save');?></a>
            </div>
        </div>
    <?php } ?>
    <?php 
    $salida= $this->here; 

    if( trim(str_replace("/index.php/","",$salida))=="Shade"){
    ?>
      <div class="btn-controls">
          <div class="btn-group btn-group-justified" style="margin-top:-6px;">
              <a class="btn btn-cancel" onclick="cancel();" href="#"><?php echo __('Cancel');?></a>
              <a class="btn btn-save" onclick="setshades()" href="#"><?php echo __('Apply');?></a>
          </div>
      </div>
<?php }  

    if( trim(str_replace("/index.php/","",$salida))=="/CustomerList"){
    ?>
      <div class="btn-controls col-sm-12 col-xs-12">                
        <div class="btn-controls col-sm-12 col-xs-12">   
            <div class="col-xs-12 col-sm-12">
                <a class="btn btn-save btn-custom-large" onclick="event.preventDefault();globalMasterSave()" href="#" id="btnSave"><?php echo __('Save');?></a>
            </div>
        </div>
      </div>
<?php } ?>
    
    
</div><!-- /#footer -->

<script>
  $(document).ready(function(){
    $('#btnSave').click(function(e) {
       e.preventDefault(); 
    });
  });
</script>
