<?php
	/**
	 * return dom into a variable with curl request
	 */
	class Curl
	{
		public function getData($url){
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}
		public function details($var){
			die('died'.'<pre>'.print_r($var, true));
		}
	}
?>