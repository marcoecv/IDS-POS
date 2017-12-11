
<div id="mainCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#mainCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
    
      <div class="item active">
        <a href="/index/register">
          <?php echo $this->Html->image('/img/custom_site/slide1.jpg', array('alt' => '')); ?>
        </a>
        <div class="carousel-caption">
          <a href="/index/register" class="btn btn-default btn-lg orange" type="button">Regístrate!</a>
        </div>
      </div>
      
      <div class="item">
        <a href="/index/register">
          <?php echo $this->Html->image('/img/custom_site/slide2.jpg', array('alt' => '')); ?>
        </a>
        <div class="carousel-caption">
          <a href="/index/register" class="btn btn-default btn-lg orange" type="button">Regístrate!</a>
        </div>
      </div>
      
    </div>

    <!-- Controls 
    <a class="left carousel-control" href="#mainCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#mainCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
    -->
</div>
<!-- /Slider -->