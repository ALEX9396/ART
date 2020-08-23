<?php
	
	function autoloader($class){
		$file = __DIR__."/main/".$class.".php";
		
		if(file_exists($file)){
			require $file;
		}
	}
	
	spl_autoload_register('autoloader');
	
 ?>