
<div class="container">    
        
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Login</div>
            </div>     

            <div class="panel-body" >

                <form name="form-login" id="form-login" class="form-horizontal" method="POST" action='<?php echo Router::url('/', true); ?>Pages/dologin'>
                   
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="user" type="text" class="form-control" name="user" value="" placeholder="Userrrrrrrr">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>                                                                  

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <button type="submit" id='submit' href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log intrrtr</button>
                        </div>
                    </div>

                </form>     

            </div>                     
        </div>  
    </div>
</div>
