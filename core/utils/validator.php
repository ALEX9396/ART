<?php
	
	function isImage($type){
		$exploded = explode("/",$type);
		$t = $exploded[0];
			
		if(!isset($type[1])){
			return false;
		}
			
		$exts = ['png','jpg','jpeg'];
		$ext = strtolower($exploded[1]);
			
		return ($t=='image'&&in_array($ext, $exts));
	}
		
	function isOfMaxSize($size, $max){
		return (($size/1000)<=$max);
	}

	function isEmail($str){
		return preg_match("/([a-zA-Z0-9\._])+@([a-zA-Z0-9_\-])+((\.){1}([a-zA-Z]){2,})(((\.){1}([a-zA-Z]){2,}){0,1})/", $str);
	}
	
	function validatePhone($phone){
		$reg = "((07)|(\+2547))([0-9]){8}";
		return preg_match("/$reg/", $phone);
	}
	
	function validatePassword($password){
		if(strlen($password)>=MIN_PWD_LENGTH){
			if(preg_match("/([a-z])+/", $password)&&
			preg_match("/([A-Z])+/", $password)&&
			preg_match("/([0-9])+/", $password)&&
			preg_match("/([\W_])+/", $password)
			){
				return PWD_VALID;
			}

			return ERR_PWD_INVALID;
		}else{
			return ERR_PWD_SHORT;
		}
	}
	
	function validateName($name){
		$reg = "/[0-9\W_]/";
		
		return (!preg_match($reg, $name));
	}
 ?>