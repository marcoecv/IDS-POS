<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title><?php echo __('Request New Account');?></title>

</head>

<body>

<h1><?php
if($data['type'] == 'P'){
    echo __('Request New Account Player(s)');
}else{
    echo __('Request New Account Sub-Agent');
}
?></h1>

<?php if($data['type'] == 'P'){ ?>

    <?php foreach($data['accounts'] as $account){ ?>
        <table class='account'>
            <tr><td><?php echo __('Password');?>: </td> <td><?php echo $account->password; ?></td></tr>
            <tr><td><?php echo __('Credit Limit');?>: </td> <td><?php echo $account->creditLimit; ?></td></tr>
            <tr><td><?php echo __('Bet Quick Limit');?>: </td> <td><?php echo $account->betQuickLimit; ?></td></tr>
            <tr><td><?php echo __('Settle Figure');?> : </td> <td><?php echo $account->settleFigure; ?></td></tr>
            <tr><td><?php echo __('Agent');?>: </td> <td><?php echo $account->agent; ?></td></tr>
        </table>
    <?php } ?>
<?php } else{ ?>
    <table class='account'>
        <tr><td><?php echo __('Sub Agent');?>: </td> <td><?php echo $data['accounts']->subagent; ?></td></tr>
        <tr><td><?php echo __('Password');?>: </td> <td><?php echo $data['accounts']->password; ?></td></tr>
        <tr><td><?php echo __('Commission');?>: </td> <td><?php echo $data['accounts']->commission; ?></td></tr>
        <tr><td><?php echo __('Rols');?> : </td> <td><?php echo $data['accounts']->rols; ?></td></tr>
    </table>
<?php } ?>
</body>
</html>