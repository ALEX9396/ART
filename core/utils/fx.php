<?php

	function getFetchMeta(array $data){
		$total = $data['total'];
		$limit = $data['limit'];
		$fetched = $data['fetched'];
		$page = $data['page'];

		$res = [];

		/* Pages */
		if($fetched>$limit){
			$res['next_page'] = $page + 1;
		}
		
		if($page>1){
			$res['prev_page'] = $page - 1;
		}
		
		$res['current_page'] = $page;
		
		$total_pages = 1;
		
		if($total>$limit){
			$rem = $total%$limit;
			$total_pages = ($total - $rem)/$limit;
			if($rem>0){
				$total_pages += 1;
			}
		}
		
		$res['total_pages'] = $total_pages;
		
		/* Current set of results being shown */
		$from = (($limit*$page)-$limit)+1;
		$to = $from + $limit - 1;
		
		if($total==0){
			$from = 0;
		}
		
		if(count($listings)<$limit){
			$to = $total;
		}
		
		$res['showing_from'] = $from;
		$res['showing_to'] = $to;

		$res['total'] = $total;

		return $res;
	}

	function redirect($to){
		if(startsWith("/",$to)){
			$to = substr_replace($to, '', 0, 1);
		}

		$to = SERVER_ROOT.$to;
		
		header("location: $to");
	}

	function initContext(...$vars){
		$context = [];
		foreach($vars as $v){
			$context[$v] = null;
		}
		
		return $context;
	}
	
	function updateContext($context, $get=false){
		foreach($_POST as $key=>$val){
			if($key=='csrf_token'){
				continue;
			}
			
			$context[$key] = $val;
		}
		
		if($get){
			foreach($_GET as $key=>$val){
				if($key=='csrf_token'){
					continue;
				}
			
				$context[$key] = $val;
			}
		}
		
		return $context;
	}
	
	function parseInt($str){
		$str = preg_replace("/ +/", "", $str);
		if(preg_match("/[a-zA-Z\W_]/", $str)){
			return 0;
		}
		
		return intval($str);
	}
	
	function urlPart($str, $skips){
		$uri = explode("?", Request::server('request_uri'))[0];
		$uri = explode("/", $uri);
		
		$skips = $skips+1;
		
		for($i=0; $i<count($uri); $i++){
			if($uri[$i]==$str){
				if(isset($uri[$i+$skips])){
					return $uri[$i+$skips];
				}
			}
		}
			
		return null;
	
	}
	
	function startsWith($needle, $haystack) {
		$len = strlen($needle);
		return (substr($haystack, 0, $len) === $needle);
	}
	
	function endsWith($needle, $haystack){
		$len = strlen($needle);
		if($len==0){
			return true;
		}
		
		return (substr($haystack, -$len) === $needle);
	}
	
	function parseDate($timestamp, $time = true){
		$date = getdate($timestamp);
		$today = getdate(time());
			
		$parsed = "";
		if($date['year']==$today['year']){
			if($date['yday']==$today['yday']){
				$parsed = "Today";
			}else if(($date['yday']+1)==$today['yday']){
				$parsed = "Yesterday";
			}else{
				$parsed = substr($date['month'],0,3)." ".$date['mday'];
			}
		}else{
			$parsed = substr($date['month'],0,3)." ".$date['mday'].", ".$date['year'];
		}
			
		if($time){
			$hr = $date['hours'];
			$min = $date['minutes'];
				
			if($hr<10){
				$hr = "0".$hr;
			}
				
			if($min<10){
				$min = "0".$min;
			}
				
			$parsed.=" ".$hr.":".$min;
		}
			
		return $parsed;
	}
	
	function uploadFile($tmp, $destination){
		if(!startsWith('/', $destination)){
			$destination = '/'.$destination;
		}
		
		return move_uploaded_file($tmp, $_SERVER['DOCUMENT_ROOT']."/".$destination);
	}
	
	function randStr($l){
		
		$alpha = "0the1quick2brown3foxjumped4over5the6slow7lazy8dog9";
		$c = strlen($alpha)-1;
		$ran = "";
		
		for($i = 0; $i<$l; $i++){
			$r = rand(0, $c);
			$ran .= substr($alpha, $r, 1);
		}
		
		return $ran;
	}
 ?>