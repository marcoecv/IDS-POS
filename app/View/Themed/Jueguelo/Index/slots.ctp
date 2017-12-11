
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
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-slots-01.jpg');"></div>

                 <div class="carousel-caption">
                	<div class="center-block">
                        <h3>El casino en línea premium</h3>
                        <a class="btn btn-default btn-lg" href="/index/register">Empieza a Jugar</a> </div>
            	</div> 
            </div>
            
             <div class="item">
                <div class="fill" style="background-image:url('/theme/jueguelo/img/custom_site/slider-slots-02.jpg');"></div>
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
        <div class="row margin-bottom-30">
        	<h1 class="page-header">Jugar tragamonedas nunca ha sido más sencillo, seguro y divertido!</h1>
        	<div class="col-md-7">
            	
              <p>Estos son tiempos emocionantes para los fanáticos de las tragamonedas que desean jugar desde su hogar.</p>
              <p>Nuestra gama completa de tragamonedas está diseñada para su diversión, entretenimiento, facilidad de uso y la disponibilidad las 24 horas del día.</p>
              
              <p>Esto significa que los jugadores en línea ahora pueden disfrutar de las clásicas tragamonedas de cinco rodillos.</p>
			  <p>Los jugadores de tragamonedas online también pueden encontrar muchos juegos de tres rieles, además de todas las versiones de 7s and Bars.</p>
            </div>
           
            <div class="col-md-5 pull-right">
            	<img src="img/img-slots01.png" class="img-responsive" alt="Deportes">
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Service Tabs -->
        <div class="row">
        	
            <!-- .col 12 -->
            <div class="col-lg-12">

                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#service-one" data-toggle="tab">Video Slots</a></li>
                    <li class=""><a href="#service-two" data-toggle="tab">Jackpot</a></li>
                    <li class=""><a href="#service-three" data-toggle="tab">Poker</a></li>
                    <li class=""><a href="#service-four" data-toggle="tab">Card Games</a></li>
                    <li class=""><a href="#service-five" data-toggle="tab">Roulette</a></li>
                    <li class=""><a href="#service-six" data-toggle="tab">More</a></li>
                </ul>

                
                <!-- .tab-content -->
                <div id="myTabContent" class="tab-content">
                    <!-- Start First Tab -->
                    <div class="tab-pane fade active in" id="service-one">
                    
                            <!-- Service Panels -->
                            <div class="row">
                             <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Ghost Rider<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/grider.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                   
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          King Kong<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/king-kong.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Spider Man<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/spiderman.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          X-Men<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/xmen.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Age of the Gods<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/age-of-the-gods.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                         Dr. Love More<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/dr-lovemore.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Santa Surprise<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/ssurp.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                               
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Marvel Avengers<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/avengers.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Beach Life<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/beach-life.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Blade<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/blade.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Captain America<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/captain-america.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Captains Treasure<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/captains-treasure.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Dare Devil<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/daredevil.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Desert Treasure<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/desert-treasure.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Gladiator<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/gladiator.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Iron Man 3<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/iron-man-3.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                               
                                
                                
                            </div>
                            <!--End all Service Panels -->
                    
                    </div>
                    
                    
                    
                    <!-- Starts Panel Two Jackpots -->
                    <div class="tab-pane fade" id="service-two">
  
  						  <!-- Service Panels -->
                            <div class="row">
                            
                            
                            
                            
                             <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Spamalot<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/monty-pythons-spamalot.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                   
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Thor<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/thor.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Gold Rally<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/gold-rally.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Hulk<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/the-incredible-hulk.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Fantastic4 - 50 Lines<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/f4-50-lines.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                         Fantastic4<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/f4.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                               
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Marvel Avengers<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/avengers.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Blade<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/blade.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Captain America<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/captain-america.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Dare Devil<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/daredevil.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Desert Treasure<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/desert-treasure.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Gladiator Jackpot<img class="ic-mobile" src="/theme/jueguelo/img/custom_site/ic-mobile.png">
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/video/gladiator.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                            </div>
                            <!--End all Service Panels -->
  
  
                    </div>

					
                    
                     <!-- Start tab #3 ----------------------------------------------------------------------->
                    <div class="tab-pane fade" id="service-three">
                    
                    <!-- Service Panels -->
                            <div class="row">
                            
                            
                             <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Aces<br>Faces
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfaces.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Aces Faces<br>Multiplayer
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfacesmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Caribbean<br>Poker
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/caribbeanpoker.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Three Card<br>Poker
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/threecardpoker.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Jacks or Better
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jackorbetter.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Tens or Better
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/tensorbetter.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Deuces Wild
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/deuceswild.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Joker Wild
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jokerwild.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Aces & Faces
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfaces.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Jacks or Better Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jackorbettermulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Tens or Better Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/tensorbettermulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Deuces Wild Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/deuceswildmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Joker Wild Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jokerwildmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                
                              
                              </div>
								<!-- /End four boxes Container for Games Service Panels -->
                    
                    </div>
                    
                    
                    <!-- Start tab #4 -->
                    <div class="tab-pane fade" id="service-four">
                    
                     
                            <!-- Service Panels -->
                            <div class="row">
                            
                            
                            
                            
                             <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Aces<br>Faces
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfaces.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Aces Faces<br>Multiplayer
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfacesmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          American<br> Roulette
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/americanroulette.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Baccarat<br>&nbsp
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/baccarat.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Paigow<br>&nbsp
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/paigow.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Caribbean<br>Poker
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/caribbeanpoker.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Three Card<br>Poker
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/threecardpoker.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Jacks or Better
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jackorbetter.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Tens or Better
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/tensorbetter.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Deuces Wild
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/deuceswild.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Joker Wild
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jokerwild.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Aces & Faces
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/acesfaces.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Jacks or Better Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jackorbettermulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Tens or Better Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/tensorbettermulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Deuces Wild Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/deuceswildmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Video Poker<br>Joker Wild Multi
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/jokerwildmulti.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Craps<br>&nbsp
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/craps.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Caribbean Islands<br>Slots, 3 reel
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/caribbeanislandslots.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Goldfever<br>3 reel, 3 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/goldfeverslots.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Monstertruck<br>5 reel, 9 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/monstertruckslots.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Great Circus<br>5 reel, 9 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/greatcircusslots.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Roman Colosseum<br>5 reel, 9 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/romancolosseum.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Treasure of the Nile<br>5 reel, 9 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/treasureofthenile.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          The Maya's Secret<br>5 reel, 9 paylines
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/mayasecret.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Black Jack<br>VIP
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/casino/bjvip.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                                <!----------------->
                                
                                
                                
                              
                              </div>
								<!-- /End four boxes Container for Games Service Panels -->
                    
                    </div> <!-- /End container for individual roulette tab -->
                    
                    
                    
                   <!-- Starts roulette games ------------------------------------->
                   <div class="tab-pane fade" id="service-five">
                   
                   
                   <!-- Service Panels -->
                    <div class="row">
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Marvel Roulette
                                  </div>
                                  <span>
                                  <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-marvel-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  3d Roulette Premium
                                  </div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-3d-roulette-premium.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Live Roulette</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-live-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Roulette Pro</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-premium-pro-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Premium French Roulette</div>
                                  <span>
                                  <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-prem-fr-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Premium Roulette Pro
                                  </div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-premium-pro-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  3d Roulette</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-3d-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Multiplayer Roulette</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-multiplayer-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Mini Roulette</div>
                                  <span>
                                  <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-mini-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Premium American Roulette</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-premium-american-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  American Roulette </div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-american-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-default text-center">
                              <div class="panel-heading" id="panelpadding">
                                  <div style="position:relative; padding:1em 0">
                                  Multi Player FR Roulette</div>
                                  <span>
                                   <img class="img-responsive" src="/theme/jueguelo/img/custom_site/slots/roulette/vegas-multi-fr-roulette.jpg"> </span>
                              </div>
                                <div class="panel-body">
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                </div>
                            </div>
                        </div>
                        
                        <!----------------->
                        
                    </div>
					<!-- /End four boxes Container for Games Service Panels -->
                    
                    </div> <!-- /End container for individual roulette tab -->
                    
                    
                    
                    
                   <!-- Starts other games tab five-->
                   <div class="tab-pane fade" id="service-six">
                   
                   
                   <!-- Service Panels -->
                    <div class="row">
                        
                    
                      			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Admiral Nelson
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/admiral-nelson.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  
                   				<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          All Ways Fruits
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/all-ways-fruits.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Arising Phoenix
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/arising-phoenix.png" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Blue Dolphin
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/blue-dolphin.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Book of Aztec
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/book-of-aztec.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Hot 81
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/hot-81.png" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Hot Diamonds
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/hot-diamonds.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Hot Neon
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/hot-neon.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  				
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Lady Joker
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/lady-joker.png" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  			 <div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Magic Idol
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/magic-idol.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  
                   			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Mermaids Gold
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/mermaids-gold.jpg" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                   			<div class="col-md-3 col-sm-6">
                                    <div class="panel panel-default text-center">
                                      <div class="panel-heading" id="panelpadding">
                                        <div style="position:relative; padding:1em 0">
                                          Wild Shark
                                          </div>
                                          <span>
                                          <img src="/theme/jueguelo/img/custom_site/slots/others/wild-shark.png" width="100%" class="img-responsive" > </span>
                                      </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#loginmodal">Play Now</a>
                                            <a href="#" class="btn btn-default btn-sm">Demo</a>
                                        </div>
                                    </div>
                                </div>
                  <!----------------->
                  
                  
                  
                  </div><!-- /End four boxes Container for Games Service Panels -->
                    
                  </div> <!-- /End container for individual roulette tab -->
  
                </div><!-- End tabs-content -->
                
           	 </div> <!-- End .col-lg-12-->
           
           </div> <!-- / .row Service Tabs -->
           
        <!-- Call to Action Section -->
        <div class="row toplarge">
            <div class="col-md-12">
                <h3>Si usted puede disfrutar diariamente de los beneficios de nuestras recompensas de devolución. Usted puede tener la seguridad de configuración de la máquina tragaperras móviles es de un 98% de retorno.</h3>
                <p>Le damos la bienvenida al Casino en línea y nuestros anfitriones del casino estarán a su disposición para ayudarle a mejorar su experiencia de juego. Buena suerte, y no dude en ponerse en contacto con nosotros en cualquier momento para preguntas o asistencia.</p>
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

