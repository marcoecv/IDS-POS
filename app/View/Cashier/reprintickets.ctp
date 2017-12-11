<div class=" container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
        

    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">


                </div>

                <div class="box-body" style="padding: 2px;">


                    <div class="col col-md-12">
                        <table id="ticketsr" class="table table-bordered table-hover"
                               style="width: 98% !important;table-layout: fixed;">
                            <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>#Ticket</th>
                                <th>Fecha/Hora</th>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                                <th>Riesgo</th>
                                <th>Gane</th>
                                <th>Imprimir</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($tickets as $ticket) {
                                if ($ticket['Pay'] == 'false' &&  $ticket['WagerStatus'] == 'Pending') {
                                    ?>
                                    <tr>
                                        <td><?php echo $ticket['UserAccount'] ?></td>
                                        <td><?php echo $ticket['TicketNumber'] ?></td>
                                        <td><?php echo substr($ticket['TranDateTime'], 0, 19) ?></td>
                                        <td><?php echo $ticket['WagerType'] ?></td>
                                        <td><?php echo $ticket['Description'] ?></td>
                                        <td style="text-align: right"><?php echo number_format($ticket['Risk'],2,'.','') ?></td>
                                        <td style="text-align: right"><?php echo number_format($ticket['ToWinAmount'],2,'.','') ?></td>

                                        <td style="cursor: pointer;"
                                            onclick="reprintTicket(<?php echo $ticket['TicketNumber'] ?>)"><i
                                                class="ticket-print fa fa-print"></i></td>
                                    </tr>

                                    <?php
                                }
                            } ?>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>

                </div>


                <!-- /.box-body -->
            </div>
        </div>


    </div>


</div>











