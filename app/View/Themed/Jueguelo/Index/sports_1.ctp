
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
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-sports-01.jpg');"></div>
              <div class="carousel-caption">
                	<div class="center-block">
                        <h3>100% Bonus de Bienvenida</h3>
                        <a class="btn btn-default btn-lg" href="/index/register">Regístrate</a></div>
           	  </div>
            </div>
            
            <div class="item">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-sports-03.jpg');"></div>
              <div class="carousel-caption">
                	<div class="center-block">
					 <h3>Puedes ganar más apostando en vivo en pleno partido</h3>
					 <a class="btn btn-default btn-lg" href="/index/register">Empieza a Jugar</a></div>
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
    
    <!-- /Carousel -->
	  
  <!-- Page Content -->
  <div class="container page-container">
	  <!-- Intro Content -->
	  <div class="row">
		  <h1 class="page-header">Apuestas Deportivas</h1>
		  <div class="col-md-7">
			<p>Contamos con las mejores apuestas en deportes.</p>
			<p>Ponemos a su disposición la mayor oferta de apuestas en más de 90 deportes. Busque sus apuestas favoritas y saque provecho de sus conocimientos con las apuestas deportivas online. Apueste en fútbol, tenis, baloncesto o en otro deporte de su elección. Realice apuestas en diversos torneos, ligas y competiciones apasionantes.</p>
			
			<p>Mientras que muchas personas les gusta las apuestas en fútbol, baloncesto ó béisbol, hay mucho más disponible para los apostadores de deportes.</p>
			<p>Te ofrecemos un servicio de atención al cliente de primer nivel, promociones exclusivas, apuestas en directo, total seguridad y la mejor página de apuestas que puedas encontrar. Los deportes son mucho más divertidos cuando se apuesta dinero. Intentamos cubrir todas las competiciones y citas deportivas que nos es posible. Cualquier deporte y competición lo podrás encontrar aquí.</p>
			<p>Como usuario nuestro que eres hacemos lo imposible para que te sientas especial. Siempre tendrás a nuestro equipo de soporte disponible para atenderte y además podrás disfrutar de nuestros beneficios. </p>
			<a class="btn btn-primary" href="/index/register">Registrarse</a>
		  </div>
		  
		  <div class="col-md-5 text-center pull-right">
			<?php echo $this->Html->image('/img/custom_site/img-sports03.png', array('class' => 'img-responsive margin-top-20', 'alt' => 'Deportes')); ?>
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

