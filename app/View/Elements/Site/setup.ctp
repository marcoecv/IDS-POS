<div class="col-md-12" id="contentPanel">
    <section class="panel" style=" height:340px;">
        <div class="panel-body" style=" height:340px;">
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped">
                    <tbody align="center" style="background-color: white;">
                        <tr>
                            <th style="width: 140px;">Site</th>
                            <th id="url" colspan="3">
                                <div class="form-group">
                                    
                                    <select class="form-control" id="cbxSite" >
                                        <?php
                                            $theme = $this->App->getDomain('theme');
                                            $row=1;
                                            foreach ($sites as $site){
                                                if($theme == $site["SitesName"]){
                                                    echo "<option value='".$site["SitesName"]."' selected>".$site["SitesName"]." (".$site["URL"]." )</option>";
                                                }
                                                else{
                                                    //echo "<option value='".$site["SitesName"]."'>".$site["SitesName"]." (".$site["URL"].")</option>";
                                                }
                                            }
                                        ?>        
                                    </select>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td>Template </td>
                            <td colspan="3">
                                <div class="form-group">
                                    <select class="form-control" id="cbxTemplate">
                                        <option value="0">Template</option>
                                        <?php
                                            foreach ($templates as $template){
                                                echo "<option value='".(string)$template["TemplateID"]."'>".$template["NameTemplate"]."</option>";
                                            }
                                        ?>        
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Line Type Format </td>
                            <td id="lineTypeFormat" colspan="3">
                                <div class="form-group">
                                    <select class="form-control" id="cbxLineTypeFormat">
                                        <option value="0">Line Format Type</option>
                                        <?php
                                            $row=1;
                                            foreach ($linesFormatTypes as $format){
                                                echo "<option value='".$format["Name"]."'>".$format["Name"]."</option>";
                                            }
                                        ?>        
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Language </td>
                            <td colspan="3">
                                <div class="form-group">
                                    <select class="form-control" id="cbxLanguage">
                                        <option value="0">Language</option>
                                        <?php
                                            $row=1;
                                            foreach ($languages as $language){
                                                echo "<option value='".$language["Name"]."'>".$language["Name"]."</option>";
                                            }
                                        ?>        
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Bets Types </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkStraight" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="Straight"  >
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkParlay" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="Parlay"  >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkRndRobin" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="Rnd. Robin"  >
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkTeaser" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="Teaser"  >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkIfBet" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="If Bet"  >
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <input id="chkReverse" type="checkbox" class="cheked" value="" >
                                    </span>
                                    <input class="form-control" type="text" readonly="" value="Reverse"  >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Menu Options</td>
                            <?php
                                $row=1;
                                foreach ($menuOptions as $menuOption){
                            ?>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <input id="chk<?php echo $menuOption["Name"]; ?>" type="checkbox" class="cheked" value="<?php echo $menuOption["Name"]; ?>" group="MenuOptions" >
                                            </span>
                                            <input class="form-control" type="text" readonly="" value="<?php echo $menuOption["Name"]; ?>"  >
                                        </div>
                                    </td>
                            <?php
                                if($row % 2 == 0 && $row != sizeof($menuOptions)){
                                    ?>
                                        <tr>
                                            <td></td>
                                    <?php            
                                    }
                                    
                                    $row++;
                                }
                            ?>
                        </tr>
                        <tr>
                            <td>Info General</td>
                            <?php
                                $row=1;
                                foreach ($infoGeneral as $infoGen){
                            ?>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <input id="chk<?php echo $infoGen["Name"]; ?>" type="checkbox" class="cheked" value="<?php echo $infoGen["Name"]; ?>" group="InfoGeneral" >
                                            </span>
                                            <input class="form-control" type="text" readonly="" value="<?php echo $infoGen["Name"]; ?>"  >
                                        </div>
                                    </td>
                            <?php
                                    if($row % 2 == 0 && $row != sizeof($infoGeneral)){
                                    ?>
                                        <tr>
                                            <td></td>
                                    <?php            
                                    }
                                    
                                    $row++;
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 container btn-controls">
                <div class="wrap-btn-custom text-right">
                    <div class="col-xs-6" style="padding-right: 2px;">
                    </div>
                    <div class="col-xs-6" style="padding-left: 2px;">
                        <button class="btn btn-save" href="#" id="btn_save"><?php echo __('Save');?><i class='awesome-icon-ok'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>	
</div>