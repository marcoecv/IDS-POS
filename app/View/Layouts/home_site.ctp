<!DOCTYPE html>
<html>
<head>
    <?php global $browser_cache_version;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $this->fetch('title');?></title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/plugins/Font-Awesome/3.0.2/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/Font-Awesome/3.0.2/css/font-awesome-ie7.min.css">
	<!--<link rel="stylesheet" href="/plugins/modal/jquery.modal.css">-->
	<link rel="stylesheet" href="/css/jquery-ui.css">

    <?php echo $this->fetch('css'); ?>
    
    <script src='/js/jquery-1.11.2.min.js'></script>
	<script src='/js/jquery-ui.js'></script>
    <script src='/bootstrap/js/bootstrap.js'></script>
	<!--<script src='/plugins/modal/jquery.modal.js'></script>-->
    <?php echo $this->fetch('script'); ?>
</head>
<body class="hold-transition">
    <?php echo $this->fetch('content'); ?>
    <?php echo $this->element('google-analytics'); ?>
    
    <script>
        function getCurrentSize(){
            var width=window.innerWidth;
        
            if(width>=1200)
                return 'lg';
            else if(width>=992)
                return 'md';
            else if(width>=768)
                return 'sm';
            else
                return 'xs';
        }
        
        function setBodyType(){
			var winSize=getCurrentSize();
			
			var body=$("body");
			
			if(!body.hasClass(winSize))
				body.addClass(winSize);
			
			if(body.hasClass("xs") && winSize!="xs")
				body.removeClass('xs');
			
			if(body.hasClass("sm") && winSize!="sm")
				body.removeClass('sm');
			
			if(body.hasClass("md") && winSize!="md")
				body.removeClass('md');
			
			if(body.hasClass("lg") && winSize!="lg")
				body.removeClass('lg'); 
			
		}
		
		setBodyType();
        
        $(document).ready(function(){
			window.onresize = function(){
				setBodyType();
				//ajustScroller();
			};
			setBodyType();
			//initScroller();
		});
	</script>
</body>
</html>