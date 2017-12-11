<!DOCTYPE html>
<html>
<head>
    <?php global $browser_cache_version;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $this->fetch('title');?></title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">

    <script src='/js/jquery-1.11.2.min.js'></script>
    <script src='/bootstrap/js/bootstrap.js'></script>
    <script src='/plugins/montrezorro-bootstrap-checkbox/js/bootstrap-checkbox.js'></script>
    <style>
        
        body {
            background-color: white;
        }
        .container{
            margin-top: 150px;
        }
        
       @media screen and (max-width: 360px) {
            .container{
                 margin-top: 0;
            }
        }
        
        #loginbox {
            margin-top: 30px;
        }
        
        #loginbox > div:first-child {        
            padding-bottom: 10px;    
        }
        
        .iconmelon {
            display: block;
            margin: auto;
        }
        
        #form > div {
            margin-bottom: 25px;
        }
        
        #form > div:last-child {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .input-group{
            margin: 10px;
        }
        .panel {    
            background-color: transparent;
            border: 1px solid #25313c;
        }
        
        .panel-body {
            padding-top: 30px;
            background-color: rgba(2555,255,255,.3);
        }
        
        #particles {
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;                        
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
            z-index: -2;
        }
        
        .iconmelon,
        .im {
          position: relative;
          width: 150px;
          height: 150px;
          display: block;
          fill: #525151;
        }
        
        .iconmelon:after,
        .im:after {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
        }
        
        .btn-primary, #submit.btn-primary{
            background: #333;
            color: #fff;
            border-color:#ccc;
            
            -webkit-transition: all 200ms ease-in-out 0s;
                -moz-transition: all 200ms ease-in-out 0s;
                  -o-transition: all 200ms ease-in-out 0s;
                     transition: all 200ms ease-in-out 0s;
        }
        
        .btn-primary:hover, #submit.btn-primary:hover{
            background: #fe623c;
            color: #333;
        }
        
        .panel-default > .panel-heading{
            background: #25313c;
            color: #fff;
        }
        
        .alert{
            background: #ddd;
            border: 1px solid #ccc; 
        }
        .label-checkbox{
            text-align: right;
            color: #333;
            font-weight: 400;
        }

    </style>
    
</head>
<body>
    <?php echo $this->fetch('content'); ?>
</body>
</html>
