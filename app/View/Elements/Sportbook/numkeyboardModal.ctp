<?php ?>
<div class="modal fade" id="numericKeyboardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px">
        <div class="modal-content">
            <div class="bs_header">
               
            </div>
            <div id="bs_mainBody" class="modal-body" style="height: 460px;">
                 <div id="bs_keyboard">
                     <center>
                        <input type="text" id="sp_keyboardValue" class="form-control" readonly/>
                    </center>
                    <table id="bs_keyboardTable">
                        <tr>
                            <td><button class="btn btn-default kb_button numeric" value="1">1</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="2">2</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="3">3</button></td>
                        </tr
                        <tr>
                            <td><button class="btn btn-default kb_button numeric" value="4">4</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="5">5</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="6">6</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-default kb_button numeric" value="7">7</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="8">8</button></td>
                            <td><button class="btn btn-default kb_button numeric" value="9">9</button></td>
                        </tr>
                        <tr>
                            <td><button id="sp_keyboardDelete" class="btn btn-info kb_button" value="D"><i class="glyphicon glyphicon-arrow-left"></i></button></td>
                            <td><button class="btn btn-default kb_button numeric" value="0">0</button></td>
                            <td><button class="btn btn-default kb_button numeric" value=".">.</button></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button id="sp_keyboardEnter" class="btn btn-success kb_button" value="E" data-dismiss="modal">Aceptar</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>