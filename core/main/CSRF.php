<?php
	
	class CSRF{
		static function create($csrf_key){
			if(!isset($_SESSION['csrf'][$csrf_key])||(time()>$_SESSION['csrf'][$csrf_key]['expiry'])){
				$random = "".rand(1000000,99999999)."_".time();
				$token = hash_hmac("sha256",rand(100000000, 99999999), sha1(md5(base64_encode($random))));
				$expiry = time() + 1800;
			
				$_SESSION['csrf'][$csrf_key] = [
					'token'=>$token,
					'expiry'=>$expiry,
				];
			}
			
		}
		
		static function generate($csrf_key, $echo = true){
			self::create($csrf_key);
			$csrf_token = $_SESSION['csrf'][$csrf_key]['token'];

			$widget = "<input type=\"hidden\" name=\"csrf_token\" value='$csrf_token'>";

			if($echo){
				echo $widget;
			}

			return $widget;
		}
		
		static function validate($csrf_key){
			if(!isset($_POST['csrf_token'])){
				return false;
			}
			
			$token = $_POST['csrf_token'];
			
			if((time()>$_SESSION['csrf'][$csrf_key]['expiry'])||
				($_SESSION['csrf'][$csrf_key]['token']!==$token)){
				return false;
			}
			
			return true;
		}
	}
 ?>