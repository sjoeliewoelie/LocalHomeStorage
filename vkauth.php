<?php
	if(!isset($_SESSION['access_token'])){
		if(isset($_GET['code'])){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://oauth.vk.com/access_token?client_id=3791305&client_secret=zl8zmX3VPFpVINg0GKkc&code='.$_GET['code'].'&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/');
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
	        echo curl_error($curl);
	        $out = curl_exec($curl);
	        $answer = json_decode($out);
	        $_SESSION['access_token'] = $answer->access_token;
	        $_SESSION['expires_in'] = $answer->expires_in;
	        $_SESSION['user_id'] = $answer->user_id;
	        curl_close($curl);
	        header("Location: http://".$_SERVER['HTTP_HOST']);
		}
	}
?>