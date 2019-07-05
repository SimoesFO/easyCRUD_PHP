<?php
include_once ("../inc/_autoload.php");

$obj = new UsuarioControl();

//$teste = "Franqueadora";
//$jsonConfig = file_get_contents('../config/config.json');
//$arrayConfig = json_decode($jsonConfig);
//var_dump($arrayConfig);
//echo $arrayConfig->connections->$teste->user;


//echo $rootProject;

//echo $_SERVER['PHP_SELF'];
//echo getcwd();
//echo dirname(__FILE__);
//echo substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
//echo $_SERVER['DOCUMENT_ROOT'];


/*
function scanFolder($folder) {

	$array = scandir($folder);
	unset($array[0]); // remove '.'
	unset($array[1]); // remove '..'

	foreach ($array as $key => $dir) {

		if(substr($dir, 0, 1) != '.') {

			$path = $folder.'/'.$dir;
			if(is_dir($path)) {

				echo $path."<br>";
				scanFolder($path);
			}
		}
	}
	return;
}
*/
//$result = scanFolder("..");

//print_r($result);

//$jsonConfig = file_get_contents('../config/config.json');
//$arrayConfig = json_decode($jsonConfig);
//print_r($arrayConfig->autoload);

//echo "<br>";
//echo substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
//echo $arrayConfig['project'];

/*
$array = array(
	"project" => "easyCRUD_PHP",
	"author" => "Felipe Simões",
	"connections" => array(
		"localhost" => array(
			"host" => "localhost",
			"dbname" => "projeto",
			"user" => "root",
			"pws" => "sdf"
		),
		"Franqueadora" => array(
			"host" => "localhost2",
			"dbname" => "projeto2",
			"user" => "root2",
			"pws" => "2"
		)
	)
);
*/

//echo json_encode($array);


//$obj->setNome("FElipe\ Oliverira ' Simões"));
//echo stripslashes($obj->getNome());


?>