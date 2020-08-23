<?php
	
	class Response{
		static function json($msg = null, $error = null, $data = null){
			$response = [];
			
			if($msg!=null){
				$response['message'] = $msg;
			}
			
			if($error!=null){
				$response['error'] = $error;
			}
			
			if($data!=null){
				$response['data'] = $data;
			}
			
			return json_encode($response);
		}
		
		static function get($resp, $param){
			$resp = json_decode($resp, true);
			if(!isset($resp[$param])){
				return null;
			}
			
			return $resp[$param];
		}
	}
 ?>