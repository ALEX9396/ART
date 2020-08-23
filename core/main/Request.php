<?php
	
	
	class Request{
		static function method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		static function get($key, $default=null, $safe=true){
			if(!isset($_GET[$key])){
				return $default;
			}
			
			$conn = Db::connect();
			
			if(is_array($_GET[$key])){
				$val = $_GET[$key];
				for($i=0; $i<count($val); $i++){
					$val[$i] = mysqli_escape_string($conn, $val[$i]);
					if($safe){
						$val[$i] = htmlspecialchars($val[$i]);
					}
				}
				
			}else{
				$val = mysqli_escape_string($conn, $_GET[$key]);
			
				if($safe){
					return htmlspecialchars($val);
				}
			}
			
			return $val;
		}
		
		static function post($key, $default=null, $safe=true){
			if(!isset($_POST[$key])){
				return $default;
			}
			
			$conn = Db::connect();
			
			if(is_array($_POST[$key])){
				$val = $_POST[$key];
				for($i=0; $i<count($val); $i++){
					$val[$i] = mysqli_escape_string($conn, $val[$i]);
					if($safe){
						$val[$i] = htmlspecialchars($val[$i]);
					}
				}
				
			}else{
				$val = mysqli_escape_string($conn, $_POST[$key]);
			
				if($safe){
					$val = htmlspecialchars($val);
				}
			}
			
			return $val;
		}
		
		static function file($key){
			if(!isset($_FILES[$key])){
				return null;
			}
			
			if($_FILES[$key]['name']==''||$_FILES[$key]['type']==''||$_FILES[$key]['size']==''||$_FILES[$key]['tmp_name']==''){
				return null;
			}
			
			return $_FILES[$key];
		}
		
		static function files($key){
			if(!isset($_FILES[$key])){
				return [];
			}
			
			$files = [];
			
			for($i=0; $i<count($_FILES[$key]['name']);$i++){
				array_push($files, [
					'name'=>$_FILES[$key]['name'][$i],
					'tmp_name'=>$_FILES[$key]['tmp_name'][$i],
					'type'=>$_FILES[$key]['type'][$i],
					'size'=>$_FILES[$key]['size'][$i],
					'error'=>$_FILES[$key]['error'][$i]
				]);
			}
			
			return $files;
		}
	}
 ?>