<?php
	class Router{
		public static function config(array $routes){
			//Resolve url
			$url = $_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'])[0];
			$debug = Config::get('debug');

			if($debug!=null){
				if($debug['status']){
					if(isset($debug['debug_uris'])){
						$uris = $debug['debug_uris'];
						
						foreach($uris as $u){
							$u = str_replace("/", "\/", $u);
							$url = preg_replace("/".$u."/", "", $url);
						}
					}
				}
			}

			if(!startsWith('/', $url)){
				$url = '/'.$url;
			}
			
			if(!endsWith('/', $url)){
				$url.= '/';
			}
			
			foreach($routes as $route){
				$r = $route->getUrl();
				if(!startsWith('/', $r)){
					$r = '/'.$r;
				}
			
				if(!endsWith('/', $r)){
					$r.= '/';
				}
				
				if(is_array($url)){
					$url = implode("/", $url);
				}
				
				if($r===$url){
					call_user_func($route->getFx());
					return;
				}
				
				//Wildcard routes
				if(substr_count($r, "*")>0){
					$r = explode("/", $r);
					
					$url = explode("/", $url);
					
					if(count($url)!=count($r)){
						continue;
					}
					
					$matches = true;
					
					for($i=0; $i<count($url); $i++){
						if(($url[$i]!=$r[$i]) && (substr_count($r[$i], "*")==0)){
							$matches = false;
							break;
						}
					}
					
					if($matches){
						call_user_func($route->getFx());
						return;
					}
				}
				
			}
			
			if(is_array($url)){
				$url = implode("/", $url);
			}
			
			header("404 Not Found", true, 404);

			require __DIR__."/../../error/404.html";
		}
		
	}
 ?>