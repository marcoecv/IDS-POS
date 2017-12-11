<?php $this->Html->css('custom.css', array('inline' => false)); ?>
<?php $this->Html->script('../js/plugins/jquery.cookie.js', array('inline' => false)); ?>
<?php $this->Html->script('functions.js', array('inline' => false)); ?>
<?php $this->Html->script('custom.js', array('inline' => false)); ?>
<?php $ini_array = parse_ini_file("domain.ini"); ?>
<?php $this->assign('title', "Apuestas Deportivas"); ?>
<?php echo $this->element('Index/confirmationmodal', array('message' => 'Atenciòn')); ?>
<?php echo $this->element('Index/modalLogin'); ?>
<?php echo $this->element ( 'Index/header' ); ?>

     <!-- Page Content -->
    <div class="container page-container">
        <!-- Intro Content -->
        <div class="row margin-top-20">
            <?php echo $this->Html->image('/img/custom_site/text-abrircuenta.png', array('class' => 'img-responsive center-block', 'alt' => 'Deportes')); ?>
        	<div class="col-md-12">
                <p class="text-center">Por favor complete la siguiente información de forma confidencial.</p>
                <p class="text-center">Asegúrese de llenar los campos requeridos marcados con el símbolo <span class="text-danger">*</span>.</p>
           </div>
        </div>
        <!-- /.row -->
        <!-- Formulario -->
        
        <!-- Forms -->
      <div class="row margin-top-20">
          <div class="col-lg-6 col-md-8 center-block" style="float:none">
            <div class="well bs-component">
              <form class="form-horizontal">
                <fieldset>
                  <div class="form-group">
                    <label for="inputEmail" class="col-lg-3 control-label">Email <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label">Password <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Checkbox
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="textArea" class="col-lg-3 control-label">Textarea</label>
                    <div class="col-lg-9">
                      <textarea class="form-control" rows="3" id="textArea"></textarea>
                      <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Radios</label>
                    <div class="col-lg-9">
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                          Option one is this
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                          Option two can be something else
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="select" class="col-lg-3 control-label">Selects</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="select">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                      <br>
                      <select multiple="" class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                  </div>
                   <div class="form-group text-center">
                      <button type="reset" class="btn btn-info btn-lg">Cancel</button>
                      <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div><!-- /.row form-->
        <!-- Call to Action Section -->
        <div class="row toplarge">
            <div class="col-md-12 text-center">
                Instrucciones para Formulario<br>
                AQUI NOTAS IMPORTANTES: <br>
                Usar como base formulario de SportsRoom<br>
                Dividir formulario en DOS COLUMNAS / boton abajo centrado <br>
                todo en espanol y eliminar los siguientes campos: <br>
                state 
                / ZZip/ 
                Prop codo<br>
                AGREAGAR PAIS EN EL FORMULARIO
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

