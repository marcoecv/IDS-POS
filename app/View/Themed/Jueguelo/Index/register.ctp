<?php $this->Html->css('../bootstrap/css/bootstrap.css', array('inline' => false)); ?>
<?php $this->Html->css('../bootstrap/css/bootstrap-theme.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css', array('inline' => false)); ?>
<?php $this->Html->css('custom.css', array('inline' => false)); ?> 

<?php $this->Html->script('../bootstrap/js/jquery-1.9.1.js', array('inline' => false)); ?>
<?php $this->Html->script('../bootstrap/js/bootstrap.min.js', array('inline' => false)); ?>
<?php $this->Html->script('../js/plugins/jquery.cookie.js', array('inline' => false)); ?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
 
 <div id="wrapper">
     <div class="container">
        <?php echo $this->element ( 'Index/header' ); ?>
                <article>
                  <h1>Abrir una cuenta</h1>
              </article>
                <!-- /.section -->
                <hr>
                <footer>
                    <div class="copy-rights clearfix">
                        <div class="pull-left">
                            Todos los derechos reservados para Jueguelo.com
                        </div>
                    </div>
                </footer>

            </div>
            <!-- /.container -->

        <div class="container">
        </div>
        <!-- /.container -->
    </div>
    <!-- /#wrapper -->

    <!-- Call functions on document ready -->
    <script>
        $(document).ready(function() {
            // Call Functions Like
            appMaster.aFunction();
            // Call anotherFunction
            appMaster.anotherFunction();
        });
    </script>

    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Ir al inico de la página" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
