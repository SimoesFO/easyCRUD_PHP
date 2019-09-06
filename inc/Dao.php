<?php
class Dao extends _autoload {

	private $arrayFieldsTable; // Store all field of a table.
	private $arrayPrimaryKeyTable; // Store all Pk of a table.
	private $arrayFieldsTableNoPK; // Store all field of a table, with except the PKs.
	protected $con; // Store Instance Connection.

	// CONSTRUCT
	function __construct() {

		if(!$this->con) {
			$this->con = Connection::getInstance();
		}
		$this->arrayFieldsTable = array();
		$this->arrayFieldsTableNoPK = array();
		$this->arrayPrimaryKeyTable = array();
		$this->getFieldsTablePrepare();
	}


	/************************************************************
	 * Description: Define a new instance connection to model.
	 * You can find a new instance name in file config.json
	 ************************************************************/
	public function setInstance($instanceName) {

		$this->con = Connection::getInstance($instanceName);
	}


	/************************************************************
	 * Description: Get the instance connection.
	 ************************************************************/
	public function getInstance() {

		return $this->con;
	}


	/************************************************************
	 * Description: Get all columns of the database table
	 ************************************************************/
	private function getFieldsTable($debug = false) {

		try {
			$sql = "SHOW COLUMNS FROM ".$this->getTableName();
			$stmt = $this->con->prepare($sql);
			// EXECUTE
			$isNotError = $stmt->execute();

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				$result = $stmt->fetchAll();
				return $result;
			}
			else {
				throw new Exception ("Error! Get Fields Table! ".get_parent_class(get_class($this)));
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Store in array all columns of a table, so that
	 * they can be used later.
	 ************************************************************/
	public function getFieldsTablePrepare($debug = false) {

		// Get all Field table.
		$arrayFields = $this->getFieldsTable($debug);

		// Interator for de all fields.
		foreach ($arrayFields as $field) {
			
			if($field['Key'] == 'PRI') {
				// Store PKs.
				array_push($this->arrayPrimaryKeyTable, $field['Field']);
			}
			else {
				// Store all fields, without PKs.
				array_push($this->arrayFieldsTableNoPK, $field['Field']);
			}

			// Store all fields, with PKs.
			array_push($this->arrayFieldsTable, $field['Field']);
		}
	}


	/************************************************************
	 * Description: Prepare field of table to be used in aplication.
	 * Transform all field table in camel-case pattern.
	 * Ex.: AutHor_ID => authorId
	 ************************************************************/
	public function prepareField($field) {

		$field = mb_strtolower($field);
		$arrayAux = explode("_", $field);
		$arrayAux = array_map(function($arg) { return ucfirst($arg);}, $arrayAux);
		$field = implode("", $arrayAux);
		
		return $field;
	}


	/************************************************************
	 * Description: Automatically generates a clause WHERE the a 
	 * SQL Query, base in PK of table.
	 ************************************************************/
	private function getWhereDefault() {

		// WHERE
		$where = "";
		foreach ($this->arrayPrimaryKeyTable as $pk) {
			
			$field = lcfirst($this->prepareField($pk));

			// Verifica se a PK está vazia.
			if(!isset($this->$field))
				throw new Exception ("Error! Primary Key empty!");

			$where .= $pk ." = ? AND ";
		}
		$where = substr(trim($where), 0, -4);

		return $where;
	}


	/************************************************************
	 * Description: Show all erros in a SQL Query.
	 ************************************************************/
	public function setDebug($stmt, $debug = false) {

		if($debug) {			
			echo "<br /><div style='color:red'><b>".$stmt->errorInfo()[2]."</b></div>";
			$result = $stmt->debugDumpParams();
			echo "<br />";
		}
	}


	/************************************************************
	 * Description: Store in array, all values of all columns table.
	 ************************************************************/
	private function getArrayValues($pk = false, $onlyPK = false, $debug = false) {

		$arrayValues = array();

		if(!$onlyPK) {
			// VALUES	
			foreach ($this->arrayFieldsTableNoPK as $key => $fieldName) {
				
				//Get a name of column table without '_', and in camel-case.
				$fieldNameAux = lcfirst($this->prepareField($fieldName));

				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					$function = 'get'.$this->prepareField($fieldName);
					$value = $this->$function();

					// If value is empty, define him to NULL.
					if(empty(trim($value))) {
						$value = NULL;
					}

					array_push($arrayValues, $value);
				}
			}
		}

		if($pk || $onlyPK) {
			// PK - PRIMARY KEY
			foreach ($this->arrayPrimaryKeyTable as $key => $pk) {

				$function = 'get'.$this->prepareField($pk);
				$value = $this->$function();
				array_push($arrayValues, $value);
			}
		}

		// DEBUG
		if($debug) {
			var_dump($arrayValues);
		}

		return $arrayValues;
	}


	/************************************************************
	 * Description: Sets for the object of a class all the values 
	 * ​​of a resultSet automaticlly
	 ************************************************************/
	public function setRow($row = null, $debug = false) {

		try {

			if($debug) {
				var_dump($row);
			}
			
			foreach ($row as $key => $field) {

				$function = 'set'.$this->prepareField($key);
				$this->$function($field);
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Search all row (register) of a table.
	 ************************************************************/
	public function selectAll($debug = false) {
		
		try {

			// SQL
			$sql = "SELECT * FROM ".$this->getTableName();
			$stmt = $this->con->prepare($sql);

			// EXECUTE
			$isNotError = $stmt->execute();

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, CREATE ARRAY OF OBJECTS.
				$classChild = static::class;
				$arrayObj = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$obj = new $classChild();
					$obj->setRow($row);
					array_push($arrayObj, $obj);		
				}

				return $arrayObj;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not return all data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Search a row (register) of a table with 
	 * determined ID.
	 ************************************************************/
	public function selectId($debug = false) {
		
		try {
			// WHERE
			$where = $this->getWhereDefault();

			// SQL
			$sql = "SELECT * FROM ". $this->getTableName() ." WHERE ". $where;
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(false, true, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				// IF NUMBER OF REGISTER BIGGER THAN ZERO, DEFINE VALUES FOR OBJECT.
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					$this->setRow($row);
				}

				return true;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not return data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Saves the object of a class to a table (model).
	 ************************************************************/
	public function insert($debug = false) {

		try {
			// FIELDS
			$fields = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {
				
				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					
					$fields .= $fieldName . ", ";
				}
			}
			$fields = substr(trim($fields), 0, -1);

			// PARAMS
			$params = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {

				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					$params .= "?, ";
				}
			}
			$params = substr(trim($params), 0, -1);

			// SQL
			$sql = "INSERT INTO ". $this->getTableName() ." (". $fields .") VALUES (". $params .")";
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(false, false, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				
				$id = $this->con->lastInsertId();

				// SET NEW ID TO PK FOR OBJECT.
				foreach ($this->arrayPrimaryKeyTable as $pk) {
					$function = 'set'.$this->prepareField($pk);
					$this->$function($id);
				}

				return $id;
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not insert data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}

	
	/************************************************************
	 * Description: Update detemined row (register) table.
	 ************************************************************/
	public function update($debug = false) {

		try {
			// WHERE
			$where = $this->getWhereDefault();

			// FIELDS
			$fields = "";
			foreach ($this->arrayFieldsTableNoPK as $fieldName) {
				
				$fieldNameAux = lcfirst($this->prepareField($fieldName));
				// Check if the field has defined (set).
				if(isset($this->$fieldNameAux)) {
					
					$fields .= $fieldName . " = ?, ";
				}
			}
			$fields = substr(trim($fields), 0, -1);

			// SQL
			$sql = "UPDATE ". $this->getTableName() ." SET ". $fields ." WHERE ". $where;
			$stmt = $this->con->prepare($sql);

			// VALUES
			$arrayValues = $this->getArrayValues(true, false, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				return $stmt->rowCount();
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not update data!");
			}
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Delete detemined row (register) table, with
	 * ID.
	 ************************************************************/
	public function delete($debug = false) {

		try {
			// WHERE
			$where = $this->getWhereDefault();
			
			// SQL
			$sql = "DELETE FROM ". $this->getTableName() ." WHERE ".$where;
			$stmt = $this->con->prepare($sql);

			// PK - PRIMARY KEY
			$arrayValues = $this->getArrayValues(false, true, false);

			// EXECUTE
			$isNotError = $stmt->execute($arrayValues);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {
				return $stmt->rowCount();
			}
			else {
				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not delete data!");
			}	
		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	/************************************************************
	 * Description: Execut SQL Query personality.
	 ************************************************************/
	public function executeQuery($query = null, $arrayParams = null, $debug = false) {

		try {

			// PREPARE SQL.
			$stmt = $this->con->prepare($query);

			// EXECUTE
			$isNotError = $stmt->execute($arrayParams);

			// DEBUG
			$this->setDebug($stmt, $debug);

			// CHECK IF HAS ERROR
			if($isNotError) {

				// IF NOT ERROR, BUT NUMBER OF REGISTER EQUAL ZERO, RETURN FALSE.
				if(!$stmt->rowCount()){
					return false;
				}

				return $stmt;
			}
			else {

				throw new Exception ("Error! ".get_parent_class(get_class($this))." - Could not execute query!");
			}

		}
		catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
	}


	

	
}
?>