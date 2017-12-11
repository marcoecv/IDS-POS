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
                
                <h1>¡Apuesta a las carreras de caballos estés donde estés!</h1>
                
                <p>Ya no es necesario ir al Hipódromo para jugar a las carreras americanas de caballos, hazlo desde la comodidad de tu casa desde tu PC ó telefono Móvil con la mayor seguridad y confianza. Juega en las carreras de caballos en línea desde la comodidad de tu hogar u oficina.</p>
                <p>Existe una gran tradición equina  y se celebran carreras en los hipódromos durante prácticamente todo el año. </p>
                <p>Juegalo.com ha conseguido profesionalizarse en este tipo de apuestas, ya que existe una gran variedad y cantidad de eventos disponibles. </p>
                <p><strong>Nuestro </strong>sistema de apuestas online que te permite realizar tus apuestas desde cualquier lugar  y desde la comodidad de tu casa, oficina o donde estés. </p>
                <h3>Apostar es muy fácil, sólo debes registrarte, ingresar dinero a tu cuenta y ¡listo!</h3>
                <p>Con las carreras percibidas como una oportunidad para divertirse. El negocio hípico ha ido evolucionando  y, en la actualidad, junto a las carreras de caballos y las apuestas, opera  bajo el modelo de racino (que combina carreras de caballos y casinos), permitiendo a los jugadores disfrutar de todas las ventajas desde su lugar de preferencia.</p>
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
