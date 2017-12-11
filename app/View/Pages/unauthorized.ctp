

<div class="container">    
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Permission</div>
            </div>     
            
            <div class="panel-body" >
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    You are not authorized to access.
                </div>
        
               
                <div class="col-sm-12 controls">
                    <a href='<?php echo Router::url('/sportbook/', true); ?>' type="button" class="btn btn-primary pull-left">Sportbook</a>
                    <a href='<?php echo Router::url(array('controller'=> $current_page['controller'], 'action'=>$current_page['action'])); ?>' type="button" class="btn btn-primary pull-right">Back</a>
                </div>
            </div>                     
        </div>  
    </div>  
</div>