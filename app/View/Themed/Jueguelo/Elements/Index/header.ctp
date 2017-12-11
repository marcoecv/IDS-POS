<nav class="navbar " role="navigation">

</nav>

<div>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>BM</b>Login</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form role="search" method="POST"
                  action='<?php echo Router::url(array('controller' => 'Pages', 'action' => 'poslogin'), true); ?>'>
                <div class="form-group has-feedback form-group-lg">
                    <input required id="user" type="text" class="form-control keyboard-normal input-lg" name="user"
                           placeholder="<?php echo __('Username'); ?>">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback form-group-lg">
                    <input required id="password" type="password" class="form-control keyboard-normal input-lg" name="password"
                           placeholder="<?php echo __('Password'); ?>">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback  form-group-lg">
                    <select required id="caja" class="form-control input-lg" name="caja"
                            placeholder="<?php echo __('Nro. de Caja'); ?>"></select>
                    <span class="form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback  form-group-lg">
                    <input type="submit" class="btn btn-info btn-block btn-flat btndal" type="button" value="<?=__('Enter')?>" id="btnEntrar" style="height: 70px;font-size: 40px; border-radius:6px;"/>
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>

<script>
    $(document).ready(function () {
        getAvailableBox();
        var remember = $.cookie('remember');
        if (remember == 'true') {
            $('#chkRemember').prop('checked', remember);

            var user = $.cookie('user');
            var password = $.cookie('password');
            // autofill the fields
            $('#user').val(user);
            $('#password').val(password);
        }


        $("#btnEntrar").click(function () {
            
            
            if ($('#chkRemember').is(':checked')) {
                var user = $('#user').val();
                var password = $('#password').val();

                // set cookies to expire in 14 days
                $.cookie('user', user, {expires: 14});
                $.cookie('password', password, {expires: 14});
                $.cookie('remember', true, {expires: 14});
            }
            else {
                // reset cookies
                $.cookie('user', null);
                $.cookie('password', null);
                $.cookie('remember', null);
            }
        });
    });
    
    
    function getAvailableBox(){
        $.ajax({
            url: "/Pages/boxVerificationMaintenance",
            type: 'POST',
            data: {
                "active":0,
                "option":5
            },
            success: function (data) {
                var obj=JSON.parse(data);
                var caja=$("#caja");
                $("#caja option").remove();
                caja.append("<option value=''></option>")
                $.each(obj,function(key,val){
                    caja.append("<option value='"+val["CashierID"]+"'>"+val["CashierID"]+"</option>")
                });
            }
        });
    }
</script>