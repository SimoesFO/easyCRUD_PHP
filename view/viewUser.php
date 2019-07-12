<?php
include_once ("../inc/_autoload.php");

try {
	
	$objUsuario = new UsuarioControl();
	$objPosts = new PostsUsuariosControl();
	$objCliente = new ClientesControl();
	$objComentarios = new ComentariosPostControl();
	
	Connection::beginTransaction();

	$objUsuario->setNome("Felipe 7");
	$objUsuario->setIdade(18);
	$objUsuario->setExemploTeste('Teste 7');
	$idUsuario = $objUsuario->insert();
	
	$objPosts->setIdUsuario($idUsuario);
	$objPosts->setComentario("Primeiro Post");
	$objPosts->insert();
	
	$objCliente->setNome("João da Silva");
	$objCliente->setIdade(19);
	$objCliente->insert();
	
	$objComentarios->setIdPost(1);
	$objComentarios->setComentario('comentario 1');
	$objComentarios->insert();
	
	Connection::commit();
}
catch (Exception $e) {

	Connection::rollBack();
	echo "Excessão: ";
	echo $e->getMessage();
}


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

?>