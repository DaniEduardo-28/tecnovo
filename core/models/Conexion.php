<?php
class Conexion{
	private $cn;

	public function Open(){

		$options_db = [
			PDO::ATTR_EMULATE_PREPARES   => true, // turn off emulation mode for "real" prepared statements
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . CHARSET,
		  ];

		try {
      $this->cn = new PDO("mysql:host=" . HOST_DB . "; dbname=" . DB . ";", USER_DB , PASS_DB, $options_db);
    } catch (PDOException $e) {
			echo "Error de Conexión " . $e->getMessage();
			die( print_r(mysql_errors(),true));
    }

		return $this->cn;
	}

	public function Close(){
		$this->cn = null;
	}

}
?>
