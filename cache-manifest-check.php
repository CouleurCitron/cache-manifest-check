<?php
$url = 'http://.../cache-4.manifest'; // cache manifest url

echo '<h2>CACHE MANIFEST CHECK</h2>';

echo '<h3>'.$url.'</h3>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
curl_setopt($ch, CURLOPT_TIMEOUT, 20); //timeout in seconds	   
$contents = curl_exec($ch);		
curl_close($ch);

foreach(explode("\n", $contents) as $k => $url){
	
	if (preg_match('/^[htps]{4,5}/si', $url)){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		
		$result = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		echo $url.'<br />';
		echo $http_status.' - ';	
		if ($http_status!='200'){
			echo '<strong>ERROR</strong><br /><br />';
		}
		else{
			echo 'OK<br /><br />';
		}
	}
	else{
		//echo $url.' is not an url<br />';	
	}
}
?>
