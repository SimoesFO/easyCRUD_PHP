<?php
include_once ("../inc/_autoload.php");

try {
	/*
	Connection::beginTransaction();
	
	$objUsuario = new UsuarioControl();
	$objUsuario->setNome("Felipe Simẽos");
	$objUsuario->setIdade(28);
	$objUsuario->setExemploTeste('Teste 7');
	$idUsuario = $objUsuario->insert();
	
	$objPosts = new PostsUsuariosControl();
	$objPosts->setIdUsuario($idUsuario);
	$objPosts->setComentario("Primeiro Post");
	$idPost = $objPosts->insert();
	
	$objComentarios = new ComentariosPostControl();
	$objComentarios->setIdPost($idPost);
	$objComentarios->setComentario('Primerio Comentário');
	$objComentarios->insert();
	
	Connection::commit();
	*/


	$objUsuario = new UsuarioControl();
	$objUsuario->setId(67);
	$objUsuario->selectId();
	echo $objUsuario->getNome()."<br />";

	$objUsuario->loadPostsUsuarios();
	foreach ($objUsuario->getArrayPostsUsuarios() as $key => $post) {
		echo "Id: ". $post->getId() ."<br />";
		echo "Id Usuário: ". $post->getIdUsuario() ."<br />";
		echo "Comentário: ". $post->getComentario() ."<br />";
	}
	//var_dump($objUsuario->getArrayPostsUsuarios());


}
catch (Exception $e) {

	//Connection::rollBack();
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