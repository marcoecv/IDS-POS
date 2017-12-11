<?php $this->Html->css('../bootstrap/css/bootstrap.css', array('inline' => false)); ?>
<?php $this->Html->css('../bootstrap/css/bootstrap-theme.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome.min.css', array('inline' => false)); ?>
<?php $this->Html->css('../plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css', array('inline' => false)); ?>
<?php $this->Html->css('custom.css', array('inline' => false)); ?>

<?php $this->Html->script('../js/plugins/jquery.cookie.js', array('inline' => false)); ?>
<?php $this->Html->script('functions.js', array('inline' => false)); ?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
<?php $this->assign('title', "Apuestas deportivas, juegos de casino, carreras de caballos."); ?>
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
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-index-03.jpg');"></div>
                <div class="carousel-caption" style="width:115%">
                	<div class="center-block">
                        <!-- <a class="btn btn-default btn-lg" href="registro.html">Empieza a Jugar</a> -->
                	</div>
            	</div>
            </div>
            
            <div class="item">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-index-04.jpg');"></div>
                <div class="carousel-caption" style="width:115%">
                	<div class="center-block">
                        <!-- <a class="btn btn-default btn-lg" href="registro.html">Empieza a Jugar</a> -->
                	</div>
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
    
            <!-- Team Members -->
            <div class="row">
                
                <!-- Added div and id for equal height columns -->
                <div id="equalheight">
                
                <div class="col-md-4 text-center">
                    <div class="thumbnail">
						<?php echo $this->Html->image('/img/custom_site/index-registro.jpg', array('class' => 'img-responsive')); ?>
					 <div class="caption">
						<?php echo $this->Html->image('/img/custom_site/text-registro.png', array('class' => 'img-responsive center-block')); ?>
                            <a class="btn btn-default btn-lg btn-block" href="#">Crea Tu Cuenta</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-center">
                    <div class="thumbnail">
						<?php echo $this->Html->image('/img/custom_site/index-fans.jpg', array('class' => 'img-responsive center-block')); ?>
                        <div class="caption block-center">
							<?php echo $this->Html->image('/img/custom_site/text-juega.png', array('class' => 'img-responsive')); ?>
                            <a class="btn btn-default btn-lg btn-block" href="#">Deportes en Vivo</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-center">
                    <div class="thumbnail">
						<?php echo $this->Html->image('/img/custom_site/index-play.jpg', array('class' => 'img-responsive center-block')); ?>
                        <div class="caption">
							<?php echo $this->Html->image('/img/custom_site/text-seleccion.png', array('class' => 'img-responsive')); ?>
                            <a class="btn btn-default btn-lg btn-block" href="#">Casino en Vivo</a>
                        </div>
                    </div>
                </div>
                
                </div>
                <!-- /#equalheight close -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /.container -->
    
	
        <!-- Promo -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12"> 
                	<a href="/index/register">
						<?php echo $this->Html->image('/img/custom_site/promo-soccer.jpg', array('class' => 'img-responsive','style' => 'border-radius:4px','alt' => 'REGISTRESE')); ?></a>
                </div>
            </div>
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

