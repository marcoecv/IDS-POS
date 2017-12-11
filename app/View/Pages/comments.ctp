<script>
    
$(document).ready(function(){
    $('#enter').click(function(e){
        
        var id = null;
        
        if ($('#deleteComment').is(':checked')) {
            
            e.preventDefault();
            
            id =$('#deleteComment').parents().eq(1).children('#DMessage').attr('class')
            
            var url = $(this).attr('href');
            var parametros = {
                commentId : id
            }
            
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=> 'Comments', 'action'=>'disableComment')); ?>",
                dataType: "json",        
                async: false,
                data: parametros,
                success: function(data) {
                    console.log(data);
                }
            });   
            $(location).attr('href',url);
        }
    });
});

</script>
<div class="container">    
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Comments</div>
            </div>     
            
            <div class="panel-body" >
                <?php
                   $comments['permanent'] = $this->Session->flash('P');
                   $comments['temporary'] = $this->Session->flash('T');
                   $comments['desactivable'] = $this->Session->flash('D');
                ?>
                <?php
                foreach($comments as $key=>$comment){
                    if(!empty($comment)){
                        ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $comment; ?>
                            <?php if($key == 'desactivable'){  ?>
                            <label class='label-checkbox'>
                                <input id='deleteComment' type="checkbox"> <?php echo __("Don't show this comment"); ?>
                            </label>
                            <?php } ?>
                       </div>
                        <?php
                    }
                }
                ?>
                <div class="col-sm-12 controls">
                    <div class="enter">
                     <a id='enter' href='<?php if($accountType=='M' || $accountType=='A'){ echo Router::url('/DashboardAdmin', true); }else{ echo Router::url('/Sportbook', true);} ?>' type="button" class="btn btn-primary pull-right">Enter</a>
                    </div>
                </div>
            </div>                     
        </div>  
    </div>  
</div>