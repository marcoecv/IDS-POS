<?php 
session_start();
$url=$_GET['url'];    
if(preg_match("/\?/", $url))
	$url=$url."&livebettingchecked";
else
	$url=$url."?livebettingchecked";
header('Location: '.$url);
?>