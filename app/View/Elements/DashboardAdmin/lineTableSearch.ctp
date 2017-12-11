<div class="table-row td">
    <div class="table-cell" data-th="Customer"><a href="#" onclick="lnkToPersonal('<?php echo trim($response['CustomerId']);?>')"><?php echo trim($response['CustomerId']);?></a></div>
    <div class="table-cell" data-th="First Name"><?php echo $response['NameFirst'];?></div>
    <div class="table-cell" data-th="Last Name"><?php echo $response['NameLast'];?></div>
    <div class="table-cell" data-th="Email"><?php echo $response['EMail'];?></div>
    <div class="table-cell" data-th="Adress"><?php echo $response['Address'];?></div>
    <div class="table-cell" data-th="City"><?php echo $response['City'];?></div>
    <div class="table-cell" data-th="Phone Mobil"><?php echo $response['BusinessPhone'];?></div>
    <div class="table-cell" data-th="Phone Home"><?php echo $response['HomePhone'];?></div>
    <div class="table-cell" data-th="Password"><?php echo $response['Password'];?></div>
</div>