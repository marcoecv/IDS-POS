<!-- Modal -->
<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo __('Are you sure?');?></h4>
      </div>
      <div class="modal-body">
       <span id="bodyConfirmModal" class='text-center'></span>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn" onclick="applyZeroOut()"><?php echo __('Apply Zero Out');?></button>
        <button type="button" class="btn" data-dismiss="modal"><?php echo __('Cancel');?></button>
      </div>
    </div>

  </div>
</div>