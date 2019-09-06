<?php
// Get Directory Root of Project.
$pathRoot = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

/************************************************************
 * Description: Scanner all file in a directory, search for
 * class and include this class
 ************************************************************/
function scanFolder($folder, $class_name) {

	$array = scandir($folder);
	unset($array[0]); // remove '.'
	unset($array[1]); // remove '..'

	foreach ($array as $key => $dir) {

		if(substr($dir, 0, 1) != '.') {

			$path = $folder.'/'.$dir;
			if(is_dir($path)) {

				$pathClass = "$path/".$class_name;				
				if(is_readable($pathClass)) {
					include_once $pathClass;
					return;
				}
				scanFolder($path, $class_name);
			}
		}
	}
	return;
}

/************************************************************
 * Description: Call this funcion each time create a instance
 * of the object, searching for include file this class.
 ************************************************************/
spl_autoload_register(function ($class_name) {

	$class_name = $class_name . '.php';
	$pathRoot = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
	scanFolder($pathRoot, $class_name);
});

class _autoload {
	
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