

<!-- Navigation -->
  
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background: #000;">
    
    <div class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/index/home"><?php echo $this->Html->image('/img/custom_site/logo.png', array('class' => 'img-responsive navbar-brand', 'alt' => 'Apuestas Deportivas')); ?></a>
            <span class="pull-right">
                <a href="#" id='logIn' class="btn btn-default btn-sm navbar-btn" data-toggle="modal" data-target="#modalLogin" type="button">Entrar</a>
                <a href="/index/register" class="btn btn-primary btn-sm navbar-btn">Registro</a>
            </span>
    </div>
     
    <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-inverse" id="bs-example-navbar-collapse-1" role="navigation" style="background: none;">
            <div class="container">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/index/sports">Pronósticos Deportivos</a></li>
                <li><a href="/index/live">En Vivo</a></li>
                <li><a href="/index/race">Caballos</a></li>
                <li><a href="/index/casino">Casino</a></li>
                <li><a href="/index/slots">Slots</a></li>
            </ul>
            </div>
            <!-- /links container-->
        </div>
        <!-- /.navbar-collapse -->
     
</nav>
