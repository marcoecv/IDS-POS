<div id="cajero_deposits" class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 hideShow" style="display: none">
    <div class="box cajeroBoxes">
        <div class="box-header">
            <div class="row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Cuenta: </label>
                    <div class="input-group input-group-lg">
                        <input id="findId" type="text" class="form-control keyboard-normal" placeholder="ID Cuenta" style="border-radius: 0px">
                        <span class="input-group-btn">
                            <button id="findPlayer" type="button" class="btn btn-primary btn-flat">Buscar</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bold">Propietario: </label>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control pull-right" readonly id="propietariocta">
                    </div>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bold">Disponible de Cuenta: </label>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control pull-right" readonly id="disponiblecta">
                    </div>
                </div>
            </div>
            <div class="row">
                <hr style="margin: 0px 7px 0px 7px; border-color: #0c0c0c">
            </div>
        </div>
        <div class="box-body">
            <div class="col col-md-12">
                <div id="transactionHeaderTableDiv">
                    <table id="transactionHeaderTable"class="table table-bordered  table-striped table-hover">
                        <tr>
                            <th class="tdDepDate">Fecha/Hora</th>
                            <th class="tdDedTrans">#Transaccion</th>
                            <th class="tdDepDesc">Descripcion</th>
                            <th class="tdDepDebits">Credito</th>
                            <th class="tdDepCredits">Debito</th>
                            <th class="tdDepBalance">Balance</th>
                        </tr>
                    </table>
                </div>
                <div id="transactionTableDiv">
                    <table id="transactionTable" class="table table-bordered  table-striped table-hover">
                        
                    </table>
                </div>
                
            </div>

        </div>

    </div>


</div>