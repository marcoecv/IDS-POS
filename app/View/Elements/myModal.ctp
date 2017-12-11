<div class="container">  
  <a id="exemyModal" href="#myModal" style="display:none;" role="button" class="btn btn-primary" data-toggle="modal">Submit</a>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" backdrop="static" keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title" id="myModalLabel"><?php echo __("Please Wait");?></h4>
      </div>
      <div class="modal-body center-block">
        <div class="progress">
          <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            
          </div>
        </div>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->