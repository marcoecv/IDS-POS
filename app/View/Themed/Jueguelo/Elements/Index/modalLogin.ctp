<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding: 0">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="text-align: center;margin-left: 27px;">
        <?php echo $this->Html->image('/img/custom_site/logo-smaller.png', array('style' => 'margin-top:10px;margin-bottom:10px;')); ?>
        </h4>
      </div>
      <div class="modal-body">
        <div id="frmLogin" class="form-inline">
            <div class="well">
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                            <input type="text" class="form-control" name="user" id="user" placeholder="Cuenta" value=''/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well pw">
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Clave" value=''>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loginError">
              <label>El usuario o la clave es incorrecta</label>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="txtRedirectLogin" name="redirect" value="">
                <input id="btnEntrar" class="btn navbar-btn btn-success" type="button" value="Entrar">
            </div>
        </div> 
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#btnEntrar").click(function() {
        login();
    });
    
    $(document).keydown(function(event) {
      if (event.keyCode == 13) {
        if ($("body").hasClass("modal-open")) {
          login();
        }
      }
    });
  });
  
  function login(){
    if ($.trim($("#user").val()) != "" || $.trim($("#password").val()) != "") {
      if(!doLogin($("#user").val(), $("#password").val(), "")){
        $("#user").focus();
        $(".loginError").css("display", "block");
      }
      else{
          $(".loginError").css("display", "none");
      }
    }
  }
</script>