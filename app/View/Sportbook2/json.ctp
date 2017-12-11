<?php
if(isset($data))
	echo json_encode($data);
else
	echo json_encode(array());
?>