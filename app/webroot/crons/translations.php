<?php
$ulrLogin='http://live.in-play.ag:915/pages/login_live';
$ulrTranlations='http://live.in-play.ag:915/live/makeTranslationsCache';
$username='newlive';
$password='123';

function login(&$ch, $ulrLogin, $username, $password){
	curl_setopt($ch, CURLOPT_URL, $ulrLogin);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username={$username}&password={$password}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'translationsLoginCookie');  //could be empty, but cause problems on some hosts
	//curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
	//curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp');  //could be empty, but cause problems on some hosts
	$answer = curl_exec($ch);
	if(curl_error($ch)){
		echo curl_error($ch);
	}
}

function translate(&$ch, $ulrTranlations){
	curl_setopt($ch, CURLOPT_URL, $ulrTranlations);
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	$answer = curl_exec($ch);
	if(curl_error($ch)){
		echo curl_error($ch);
	}
	echo $answer;
}

$ch = curl_init();
login($ch, $ulrLogin, $username, $password);
translate($ch, $ulrTranlations);
?>