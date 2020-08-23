<?php
	
	
	class Route{
		private $url = null;
		private $fx = null;
		
		function __construct($url, Closure $fx){
			$this->url = $url;
			$this->fx = $fx;
		}
		
		function getUrl(){
			return $this->url;
		}
		
		function getFx(){
			return $this->fx;
		}
	}
 ?>