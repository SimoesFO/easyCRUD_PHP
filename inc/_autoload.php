<?php
spl_autoload_register(function ($class_name) {

	$class_name = $class_name . '.php';
	$arrayDirectory = array(
		'', 
		'/controller', 
		'/dao', 
		'/inc');
	
	foreach ($arrayDirectory as $dir) {

		$path = getcwd()."$dir/".$class_name;		
		if(is_readable($path)) {
			include_once $path;
		}		
	}	
    
});

class _autoload {

	/*
	public function anti_injection($arg) {
		
		if(is_string($arg)) {
			$arg = trim($arg);
			$arg = addslashes($arg);
		}
		return $arg;
	}
	*/
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function __get($name) {
		return $this->$name;
	}
	
	public function __call($name, $args) {

		$arg;
		foreach ($args as $value) {
			$arg = $value;
		}
		
		$prefix = mb_strtolower(substr($name, 0, 3));
		$atributte = lcfirst(substr($name, 3, strlen($name)));
		
		if($prefix == 'get') {
			return self::__get($atributte);
		}
		else if($prefix == 'set') {
			self::__set($atributte, $arg);
		}
	}
}

?>