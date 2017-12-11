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
                
                <h1>Apuestas Deportivas</h1>
                
                <p>La fiebre de las apuestas deportivas online ha superado las fronteras de Europa, donde se encuentran las mejores casas de apuestas del mundo, y ha llegado a los países de América Latina, en una misión que se está desarrollando con pleno éxito. Es importante notar la diferencia entre las casas de apuestas que ofrecen una edición española estándar y las que ofrecenuna versión personalizada para países latinoamericanos.<br>
                </p>
                <h3>Presentamos una versión única en español  para el mercado hispanoparlante.</h3>
                 <p>
                  La verdad es que la industria de las apuestas está creciendo rápidamente en toda América Latina y se espera que siga aumentando. De hecho, se estima que esta actividad genera alrededor de de doscientos mil millones de dólares al año, considerando a México, Brasil y Argentina como los países más activos. Somos la web de apuestas más completa, con apuestas deportivas, financieras, hípicas, con apuestas sobre todos los eventos deportivos más importantes de América del Sur. No faltan promociones periódicas en las categorías más, de las carreras de caballos al fútbol latinoamericano. Si quiere apostar sobre el resultado de algún acontecimiento deportivo, Jueguelo.com es el sitio adecuado para hacerlo.
                  </p>
                 	
                </div>
                </article>
                <!-- /.section -->

                <hr>
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
