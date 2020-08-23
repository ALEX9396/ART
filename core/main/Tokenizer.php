<?php
	
	
	
	class Tokenizer{
		const SECRET = "f5sh&62#+7g%haf00@4";
		
		static function generate($str, $session = false){
			return self::getHash($str, $session);
		}
		
		static function validate($str, $hash, $session = false){
			$expected = self::getHash($str, $session);
			return hash_equals($expected,$hash);
		}
		
		private static function getHash($str, $session){
			if($session){
				$str .= Session::get('user_id');
			}
			
			return hash_hmac("sha256", $str, self::SECRET);
		}
	}
 ?>