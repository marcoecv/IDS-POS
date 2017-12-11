
<div id="header">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header navbar-agent">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" id="word" class="form-control principal" aria-label="Text input with segmented button dropdown">
                        <div class="btn-action-search input-group-btn">
                            <button type="button" class="btn btn-secondary dropdown-toggle filtre principal" >
                              <?php echo __("Filter"); ?>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                                <div class="dropdown-menu">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" checked="checked" id="filtre_player" name="checkbox-filtre"  value="1">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Player">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_agent" name="checkbox-filtre" value="2">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Agent">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_fname" name="checkbox-filtre" value="3">
                                        </span>
                                        <input type="text" disabled class="form-control" value="First Name">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_lname" name="checkbox-filtre" value="4">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Last Name">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_email" name="checkbox-filtre" value="5">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Email">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_adress" name="checkbox-filtre" value="6">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Adress">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_city" name="checkbox-filtre" value="7">
                                        </span>
                                        <input type="text" disabled class="form-control" value="City">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_mphone" name="checkbox-filtre" value="8">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Phone mobile">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="radio" id="filtre_hmobile" name="checkbox-filtre" value="9">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Phone home">
                                    </div><!-- /input-group -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" id="filtre_pw" name="checkbox-filtre" value="10">
                                        </span>
                                        <input type="text" disabled class="form-control" value="Password">
                                    </div><!-- /input-group -->
                            </div>
                            <button id="btn-find" type="button" class="btn btn-secondary principal"><?php echo __("Find"); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </nav>
</div>




