<div id="cajero_numericKeyboard" class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12  hideShow" style="display: none;">
    <div class="input-group input-group-lg" style="margin: 3px 0 3px 0">
        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
        <input id="dep_keyboardValue" readonly class="form-control input-lg" placeholder="0.00" style="width: 100%; text-align: right;border-radius: 0px;">
    </div>

    <div id="dep_keyboard">
        <table id="dep_keyboardTable">
            <tr>
                <td><button class="btn btn-default kbDep_button numeric" value="1">1</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="2">2</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="3">3</button></td>
            </tr
            <tr>
                <td><button class="btn btn-default kbDep_button numeric" value="4">4</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="5">5</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="6">6</button></td>
            </tr>
            <tr>
                <td><button class="btn btn-default kbDep_button numeric" value="7">7</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="8">8</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="9">9</button></td>
            </tr>
            <tr>
                <td><button id="dep_keyboardDelete" class="btn btn-info kbDep_button" value="D"><i class="glyphicon glyphicon-arrow-left"></i></button></td>
                <td><button class="btn btn-default kbDep_button numeric" value="0">0</button></td>
                <td><button class="btn btn-default kbDep_button numeric" value=".">.</button></td>
            </tr>
        </table>
    </div>
    <button id="sendDeposit" class="btn btn-primary" type="button">
        <span id="sendType" class="ui-keyboard-text" style="font-size:35px;">Depositar</span>
    </button>
    <button id="sendRet" class="btn btn-primary" type="button">
        <span id="sendType" class="ui-keyboard-text" style="font-size:35px;">Retirar</span>
    </button>
    <br class="ui-keyboard-button-endrow">
</div>