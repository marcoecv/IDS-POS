<?php

function printArrayJsObject($parent, $arr){
	foreach($arr as $key => $val){
		$myParent=$parent."['".$key."']";
		
		if(!is_array($val))
			echo $myParent."='$val';\n";
		else{
			echo $myParent."=new Object();\n";
			printArrayJsObject($myParent, $val);
		}
	}
}


if(isset($fullGameslines)){
	?>
	<script>
		var gamesCache=new Object();
		<?php
		printArrayJsObject("gamesCache", $fullGameslines['games']);
		?>
	</script>
	<?php
}
