<div id="cajero_payTicket" class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 hideShow" style="display: none">
    <div class="box cajeroBoxes">
        <div class="box-header">
            <div class="input-group input-group-lg col-md-4">
                <input id="findTicketId" type="text" class="form-control keyboard-num" placeholder="# de Ticket">
                <span class="input-group-btn">
                    <button id="findTicket" type="button" class="btn btn-primary btn-flat">Buscar</button>
                </span>
            </div>
        </div>
        <div class="box-body" style="padding: 2px;">
            <div class="col col-md-12">
                <div id="pt_headerTable" class="col col-md-12">
                    <table id="pt_tableHeader" class="table table-bordered  table-striped table-hover">
                        <tr>
                            <th class="tdTicket"># Tiquete</th>
                            <th class="tdFecha">Fecha / Hora</th>
                            <th class="tdSeleccion">Selecci&oacute;n</th>
                            <th class="tdRiesgo">Riesgo</th>
                            <th class="tdGanar">Por Ganar</th>
                            <th class="tdPagar">Por Pagar</th>
                            <th class="tdTipo">Tipo</th>
                            <th class="tdButton">Pagar</th>
                        </tr>
                    </table>
                </div>
                <div id="pt_tableDiv" class="col col-md-12">
                    <table id="pt_table" class="table table-bordered  table-striped table-hover">

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>