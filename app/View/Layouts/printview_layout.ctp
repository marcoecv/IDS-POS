<!DOCTYPE html>
<html lang="en">

    <head>
         <?php global $browser_cache_version; ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->script('plugins/qrcode.js?=' . $browser_cache_version); ?>
        <?php echo $this->Html->css('plugins/chosen/chosen.min'); ?>
        <?php echo $this->Html->script('plugins/chosen/chosen.jquery.min'); ?>
        <title>ticket</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/modern-business.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <?php echo $this->Html->css('sportbook'); ?>
    </head>
    <body>
        <?php echo $this->element("Printview/index"); ?>
    </body>
</html>
