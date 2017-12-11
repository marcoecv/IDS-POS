
<?php $this->Html->css('custom.css', array('inline' => false)); ?>

<?php $this->Html->script('../js/plugins/jquery.cookie.js', array('inline' => false)); ?>
<?php $this->Html->script('functions.js', array('inline' => false)); ?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
<?php $this->assign('title', "Apuestas Deportivas"); ?>
<?php echo $this->element('Index/confirmationmodal', array('message' => 'Atenciòn')); ?>
<?php echo $this->element('Index/modalLogin'); ?>
<?php echo $this->element ( 'Index/header' ); ?>
	
     
	 <!-- Header Carousel -->
     <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-horses-01.jpg');"></div>
                <div class="carousel-caption">
                	<div class="center-block">
                        <h3>El casino en línea premium para gustos selectos</h3>
                        <a class="btn btn-default btn-lg" href="/index/register">Empieza a Jugar</a> </div>
            	</div>
            </div>
            
             <div class="item">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-horses-02.jpg');"></div>
                <div class="carousel-caption">
                	<div class="center-block">
                        <h3>100% Bonus de Bienvenida</h3>
                        <a class="btn btn-default btn-lg" href="/index/register">Regístrate</a> </div>
            	</div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>
	 
   <!-- Page Content -->
   <div class="container page-container">
        <!-- Intro Content -->
        <div class="row">
        	<h1 class="page-header">Carreras de Caballos</h1>
        	<div class="col-md-7">
			   <p>Carreras de caballos del mundo entero en directo.</p>
			   <p>Ya no es necesario ir al Hipódromo para jugar a las carreras americanas de caballos, hazlo desde la comodidad de tu casa desde tu PC ó telefono Móvil con la mayor seguridad y confianza. Juega en las carreras de caballos en línea desde la comodidad de tu hogar u oficina.</p>
			   <p>Ofrecemos apuestas online para la gran mayoría de carreras del mundo, incluyendo eventos del Reino Unido, Francia, Itali, Sudáfrica, Dubai, Australia y EE.UU.</p>
			   <p> Independientemente de lo que prefiera, apuestas fijas, precios de salida o apuestas de totalizador, lo tenemos todo. Empiece ho y reclame su bono de bienvenida.</p>
			   <p>Las carreras de caballos son un clásico en las apuestas (La Quiniela Hípica, las apuestas en el propio hipódromo) </p>
			   <p>Si te gustan las carreras de caballos y aún no tienes cuenta en Jueguelo, hoy es el día para registrarte y recuerda que al inscribirte consigues el bono de bienvenida para apostar más y mejor.</p>
            </div>
            
            <div class="col-md-5 pull-right">
				<?php echo $this->Html->image('/img/custom_site/img-horses01.png', array('class' => 'img-responsive', 'alt' => 'Deportes')); ?>
            </div>
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container -->
	 
	 
	 
	 
	 
	 
	  
  
    
<?php echo $this->element ( 'Index/footer' ); ?>


<!-- Script to Activate the Carousel -->
<script>
$('.carousel').carousel({
	interval: 4000 //changes the speed
})
//
$('#logIn').on('shown.bs.modal', function () {
	$('#logIn').focus()
});
</script>

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Ir al inico de la página" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>

