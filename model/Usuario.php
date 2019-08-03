<?php

class Usuario extends Dao  {

	protected $arrayPostsUsuarios = null;

	function __construct() {

		$this->setTableName('usuario');
		parent::__construct();
	}


	public function loadPostsUsuarios($debug = false) {

		try {

			// SQL
			$query = "SELECT * FROM posts_usuarios WHERE id_usuario = :idUsuario";
			
			// PARAMS
			$arrayParams = array(':idUsuario' => $this->getId());

			// EXECUTE
			$stmt = $this->executeQuery($query, $arrayParams, $debug);

			// CHECK IF RETURNED RESULT
			if($stmt) {

				$this->arrayPostsUsuarios = array();
				// IF NUMBER OF REGISTER BIGGER THAN ZERO, CREATE ARRAY OF OBJECTS.
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$obj = new PostsUsuarios();
					$obj->setRow($row);
					array_push($this->arrayPostsUsuarios, $obj);		
				}

				return true;
			}
			else {

				return false;
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}
	
}
?>