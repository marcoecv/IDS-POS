
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
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-live-01.jpg');"></div>
                <div class="carousel-caption">
                	<div class="center-block">
                        <h3>Puedes ganar más apostando en vivo en pleno partido</h3>
                        <a class="btn btn-default btn-lg" href="/index/register">Empieza a Jugar</a> </div>
            	</div>
            </div><div class="item">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-live-02.jpg');"></div>
                <div class="carousel-caption">
                	<div class="center-block">
                        <h3>100% Bono de Bienvenida.</h3>
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
        	<h1 class="page-header">Apuestas en Vivo</h1>
        	<div class="col-md-7">
            
              <p>Bienvenido a la Zona de Apuestas en Vivo.</p>
              <p> Un sitio de obligada visita para que disfrutes aún más cualquier deporte en vivo desde aquí y ahora.</p>
              <p>Si lo que te vuelve loco es el fútbol en vivo, o nunca te pierdes un partido de baloncesto o siempre apuestas cuando ves un partido de tenis, dardos o snooker, tenemos lo que necesitas. A partir de ahora puedes ganar más apostando en vivo en pleno partido en mercados como ‘próximo gol’, ‘próximo ensayo’ o el ‘número de aces que se servirán en un set/juego’.</p>
              <p>Regístrese hoy para probar nuestra aplicación de apuestas en vivo</p>
              <p>Contamos con una oferta de mercados de apuestas en vivo enorme, en constante crecimiento, y fácilmente visible en su sitio web. La lista de los próximos eventos con disponibilidad para apostar en vio se puede apreciar en la parte izquierda de esta página o, si lo prefieres, pulsando sobre el botón ‘eventos en vivo’ del calendario para visualizar la oferta completo.</p>
              <a class="btn btn-primary" href="/index/register">¡Abre una cuenta!</a>
            </div>
            
            <div class="col-md-5 pull-right">
				<?php echo $this->Html->image('/img/custom_site/img-sports01.jpg', array('class' => 'img-responsive', 'alt' => 'Deportes')); ?>
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

