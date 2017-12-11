<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php global $browser_cache_version;?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class='xs'>
	<div id="container">
		<div id="header"></div>
		<div id="content">

			<?php //echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer"></div>
	</div>
</body>
<script>
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
	
	$(document).ready(function(){
		window.onresize = function(){
			setBodyType();
		};
		setBodyType();
	});
</script>
</html>
