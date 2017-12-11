<?php $this->Html->css('../bootstrap/css/bootstrap.css', array('inline' => false)); ?>
<?php $this->Html->css('../bootstrap/css/bootstrap-theme.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css', array('inline' => false)); ?>
<?php $this->Html->css('custom.css', array('inline' => false)); ?> 

<?php $this->Html->script('../bootstrap/js/jquery-1.9.1.js', array('inline' => false)); ?>
<?php $this->Html->script('../bootstrap/js/bootstrap.min.js', array('inline' => false)); ?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
 
 <div id="wrapper">
    <div class="container">
	<?php echo $this->element ( 'Index/header' ); ?>
    <?php echo $this->element ( 'Index/slider' ); ?>
               <article>
                <div class="section">
                
                <h1>Pronósticos en vivo</h1>
                
                <p>
                Apostar en directo o en vivo es una de las opciones más interesantes para los jugadores aficionados a las apuestas deportivas. Si queremos realizar apuestas live, Juegalo.com ofrece un gran servicio y muchas ventajas en comparación con otras casas de apuestas.
                </p>
                
                <p>Las apuestas live o apuestas en directo son aquellas en las que se interviene mientras el evento sobre el cual queremos apostar se encuentra en disputa. Dicho de otra forma, para el caso de las apuestas deportivas, mientras se está jugando el partido. Este tipo de apuestas conjugan la emoción de las apuestas con el seguimiento de nuestros eventos deportivos favoritos por lo que son cada vez más populares. 
                </p>
                
                <p>
                A todo ello se le une un factor fundamental que las hace muy propicias para ganar dinero con ellas: las rápidas variaciones en el valor de las cuotas que se producen durante el desarrollo de los encuentros. 
                </p>
                
                <h3>Realizar apuestas en vivo es muy fácil. </h3>
                
                <p>Desde la sección "Apuestas en Directo" del sitio web, podemos acceder a todos los partidos en vivo (aquellos que se ofrezcan en directo) y ver las cuotas actualizadas al instante en base a lo que suceda en los diferentes eventos deportivos.</p>                
                
                </div>
              </article>
                <!-- /.section -->
                <hr>
                <?php echo $this->element ( 'Index/footer' ); ?>
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
