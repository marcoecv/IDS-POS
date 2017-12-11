<?php
echo $this->Html->meta('icon');
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-theme.min');
echo $this->Html->css('bmdash.min');

//                data tables jquery

echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css');
echo $this->Html->css('blue.css');
echo $this->Html->css('/css/jqbtk');
echo $this->Html->css('/css//plugins/key.css');
echo $this->Html->css('/css/plugins/keyboard.css');



echo $this->Html->script('jquery-2.1.1.min');
echo $this->Html->script('bootstrap.min');


//New UI Dependencies

echo $this->Html->script('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js');
echo $this->Html->script('app.min.js');
echo $this->Html->script('plugins/iCheck/icheck.min.js');

echo $this->Html->script('/js/jqbtk.js');
echo $this->Html->script('/js/plugins/keyboard/jquery.mousewheel.js');
echo $this->Html->script('/js/plugins/keyboard/jquery.keyboard.js');
echo $this->Html->script('/js/plugins/keyboard/jquery.keyboard.extension-typing.js');
echo $this->Html->script('/js/plugins/keyboard/jquery.keyboard.extension-autocomplete.js');


echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
<?php $this->assign('title', "Apuestas deportivas, juegos de casino, carreras de caballos."); ?>

<div id="wrapper">
    <div class="container">
        <?php echo $this->element('Index/header'); ?>
        <?php echo $this->element('Index/slider'); ?>

        <div class="section">
            <div class="row">


            </div>
        </div>
        <!-- /.section -->

        <hr>

        <?php echo $this->element('Index/footer'); ?>
    </div>
    <!-- /.container -->
    <div class="container">
    </div>
    <!-- /.container -->
</div>
<!-- /#wrapper -->

<!-- Call functions on document ready -->
<script>
    $(document).ready(function () {
        // Call Functions Like
        appMaster.aFunction();
        // Call anotherFunction
        appMaster.anotherFunction();
    });
</script>

<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src='/js/plugins/keyboard/key.js'></script>


    