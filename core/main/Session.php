<?php
	
	
	class Session{
		static function start(array $data){
			foreach($data as $key=>$val){
				if(in_array($key, SESSION_PARAMS)){
					$_SESSION[SESSION_NAME][$key] = $val;
				}
			}
		}
		
		static function update($key, $val){
			if(in_array($key, SESSION_PARAMS)){
				$_SESSION[SESSION_NAME][$key] = $val;
			}
		}
		
		static function stop(){
			unset($_SESSION[SESSION_NAME]);
		}
		
		static function validate(){
			foreach(SESSION_PARAMS as $param){
				if(!isset($_SESSION[SESSION_NAME][$param])||
				($_SESSION[SESSION_NAME][$param]==null)){
					self::stop();
					break;
				}
			}
		}
		
		static function required(){
			if(!self::set()){
				if(SESSION_MISSING_REDIRECT!==null){
					$url = SESSION_MISSING_REDIRECT;
					
					if(startsWith('/', $url)){
						$url = explode('/', $url);
						unset($url[0]);
						$url = implode('/', $url);
					}
					
					$url = SERVER_ROOT.$url;
				
					//Url being accessed
					$current_url = $_SERVER['REQUEST_URI'];
					$current_url = str_replace("=", "", base64_encode($current_url));
					$tkn = Tokenizer::generate($current_url);
				
					$url.= "?rt=".$current_url."&rt_mac_token=".$tkn;
				
					header("location:".$url);
				}
			}
		}
		
		static function redirect(){
			$token = Request::get('rt_mac_token');
			$next = Request::get('rt');
			
			$url = "/user/dashboard";
			
			if(Session::get('partner_id')!=null){
				$url = "/business/dashboard";
			}
				
			if($token!=null&&$next!=null){
				if(Tokenizer::validate($next, $token)){
					$url = base64_decode($next);
				}
			}
			
			header("location: $url");
		}
		
		static function get($key){
			if(!self::set()){
				return null;
			}
			if(!isset($_SESSION[SESSION_NAME][$key])){
				return null;
			}
			
			return $_SESSION[SESSION_NAME][$key];
		}
		
		static function getAll(){
			if(!self::set()){
				return [];
			}
			return $_SESSION[SESSION_NAME];
		}
		
		static function set(){
			return isset($_SESSION[SESSION_NAME]);
		}
	
	}
 ?>