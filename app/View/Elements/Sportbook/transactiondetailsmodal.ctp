<?php ?>
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span class="modal-title"><?php echo __('Transaction Details'); ?>:&nbsp;</span><span class="modal-title" id="ticketNum"></span>
                    </div>
                    <div class="modal-body">
                        <div id="tdm_accordion">
                            
                        </div>
                    </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
			</div>
		  </div>
	</div>
</div>