<?php
echo $this->Html->css('/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css', array('inline' => false));
echo $this->Html->script('/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker');


?>
<div id="header">
    <nav class="navbar navbar-inverse">
		<div class="navbar-header">
		</div>
	</nav>
</div>

<div id="content" class='styles-home container-fluid'>
    <label for="25313C">Menus</label>
    <input type="text" data-format="hex" class="form-control" id="cp25313C" value="#25313C"/>
    
    <label for="FFFFFF">Menus Text</label>
    <input type="text" data-format="hex" class="form-control" id="cpFFFFFF" value="#FFFFFF"/>
    
    <label for="FF613B">Menus Hover</label>
    <input type="text" data-format="hex" class="form-control" id="cpFF613B" value="#1462FC"/>
    
    <label for="4EA74E">Buttons</label>
    <input type="text" data-format="hex" class="form-control" id="cp4EA74E" value="#4EA74E"/>
    
    <label for="999999">Sub Headers</label>
    <input type="text" data-format="hex" class="form-control" id="cp999999" value="#999999"/>
    
    <label for="25313C">Warning</label>
    <input type="text" data-format="hex" class="form-control" id="cpC12E2A" value="#C12E2A"/>
    
    <label for="FFFFB3">Notes</label>
    <input type="text" data-format="hex" class="form-control" id="cpFFFFB3" value="#FFFFB3"/>
    
    <script>
        $(function() {
            $('#cp25313C').colorpicker({
            });
            
            $('#cpFFFFFF').colorpicker({
                
            });
            
            $('#cpFF613B').colorpicker({
                
            });
            
            $('#cp4EA74E').colorpicker({
                
            });
            
            $('#cp999999').colorpicker({
                
            });
            
            $('#cpC12E2A').colorpicker({
                
            });
            
            $('#cpFFFFB3').colorpicker({
                
            });
        });
    </script>
</div>