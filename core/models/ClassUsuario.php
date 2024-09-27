<?php

class ClassUsuario extends Conexion {

	//constructor de la clase
	public function __construct(){

	}

	public function getLogin($name_user) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {
			$stmt = $conexion->prepare("SELECT p.*,t.name_user,t.pass_user,t.estado,g.estado as estado_grupo,t.id_trabajador,g.name_grupo,g.id_grupo FROM tb_persona p INNER JOIN tb_trabajador t ON t.id_persona=p.id_persona INNER JOIN tb_grupo_usuario g ON g.id_grupo=t.id_grupo WHERE ? in (t.name_user)");
			$stmt->execute([$name_user]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {

				$VD1['error'] = "SI";
				$VD1['message'] = "Usuario no encontrado en la base de datos.";
				$VD = $VD1;

			}else {

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			}

		} catch(PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function getLoginCliente($name_user) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];
		try {
			$stmt = $conexion->prepare("SELECT p.*,c.name_user,c.id_cliente,c.pass_user,c.src_imagen,c.estado from tb_persona p inner join tb_cliente c on c.id_persona=p.id_persona WHERE ? in (c.name_user)");
			$stmt->execute([$name_user]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {

				$VD1['error'] = "SI";
				$VD1['message'] = "Usuario no encontrado en la base de datos.";
				$VD = $VD1;

			}else {

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			}

		} catch(PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function getImageProfile($id_trabajador) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];
		try {
			$stmt = $conexion->prepare("SELECT * FROM tb_trabajador WHERE id_trabajador = ?");
			$stmt->execute([$id_trabajador]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$VD2 = "resources/global/images/default-profile.png";
			if (count($result)>0) {
				if ($result[0]['src_imagen'] != "" || $result[0]['src_imagen'] != null ) {
					$VD2 = $result[0]['src_imagen'];
				}
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $VD2;
			$VD = $VD1;

		} catch(PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function updateProfile($id_persona,$txtAddress,$txtDateNac,$txtEmail,$txtPhone) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();
			$stmt = $conexion->prepare("UPDATE tb_persona SET direccion = ? , fecha_nacimiento = ? , correo = ? , telefono = ? WHERE id_persona = ?");
			if ($stmt->execute([$txtAddress,$txtDateNac,$txtEmail,$txtPhone,$id_persona])==false) {
				throw new Exception("Ocurrió un error al actualizar los datos de perfil.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function updateProfileCliente($id_persona,$txtAddress,$txtDateNac,$sexo,$txtPhone) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();
			$stmt = $conexion->prepare("UPDATE tb_persona SET direccion = ? , fecha_nacimiento = ? , sexo = ? , telefono = ? WHERE id_persona = ?");
			if ($stmt->execute([$txtAddress,$txtDateNac,$sexo,$txtPhone,$id_persona])==false) {
				throw new Exception("Ocurrió un error al actualizar los datos de perfil.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function updateImageProfile($id_trabajador,$src) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("UPDATE tb_trabajador SET src_imagen = ? WHERE id_trabajador = ?");
			$stmt->execute([$src,$id_trabajador]);
			if ($stmt->rowCount()==0) {
				throw new Exception("Ocurrió un error al actualizar la imagen de perfil.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function updateImageProfileCliente($id_cliente,$src) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("UPDATE tb_cliente SET src_imagen = ? WHERE id_cliente = ?");
			$stmt->execute([$src,$id_cliente]);
			if ($stmt->rowCount()==0) {
				throw new Exception("Ocurrió un error al actualizar la imagen de perfil.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function UpdatePassword($id_trabajador,$txtPassOld,$txtNewPass) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();

			$stmt1 = $conexion->prepare("SELECT * FROM tb_trabajador WHERE id_trabajador = ? AND pass_user = ? ");
			$stmt1->execute([$id_trabajador,$txtPassOld]);
			$result = $stmt1->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("Contraseña actual incorrecta.");
			}

			$stmt = $conexion->prepare("UPDATE tb_trabajador SET pass_user = ? WHERE id_trabajador = ?");
			if ($stmt->execute([$txtNewPass,$id_trabajador])==false) {
				throw new Exception("Ocurrió un error al actualizar la contraseña.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function UpdatePasswordCliente($id_cliente,$txtPassOld,$txtNewPass) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {

			$conexion->beginTransaction();

			$stmt1 = $conexion->prepare("SELECT * FROM tb_cliente WHERE id_cliente = ? AND pass_user = ? ");
			$stmt1->execute([$id_cliente,$txtPassOld]);
			$result = $stmt1->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("Contraseña actual incorrecta.");
			}

			$stmt = $conexion->prepare("UPDATE tb_cliente SET pass_user = ? WHERE id_cliente = ?");
			if ($stmt->execute([$txtNewPass,$id_cliente])==false) {
				throw new Exception("Ocurrió un error al actualizar la contraseña.");
			}

			$VD = "OK";
			$conexion->commit();

		} catch(PDOException $e) {
			$conexion->rollBack();
			$VD = $e->getMessage();
		} catch (Exception $exception) {
			$conexion->rollBack();
			$VD = $exception->getMessage();
		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function getUserByCode($id_persona) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = ['error' => 'NO', 'message' => '', 'data' => []];

		try {
			$stmt = $conexion->prepare("SELECT p.*,d.name_documento FROM tb_persona p INNER JOIN tb_documento_identidad d ON d.id_documento=p.id_documento WHERE p.id_persona = ?");
			$stmt->execute([$id_persona]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {

				$VD1['error'] = "SI";
				$VD1['message'] = printError("2");
				$VD = $VD1;

			}else {

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			}

		} catch(PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	//metodo para actualizar un registro
	/*public function update($codigo, $nombres, $apellidos, $fechanacimiento, $dni, $direccion, $telefono, $genero, $foto) {
		$this->query = "call usp_updateusuario($codigo, '$nombres', '$apellidos', '$fechanacimiento', '$dni', '$direccion', '$telefono', $genero, '$foto');";
		$this->execute_single_query();
		return $this->query;
	}

	//metodo para listar usuarios por tipo de usuario y por limite de registros
	public function listarbytipo($tipousuario, $cantidadRegistros) {
		$this->query = "call usp_listarusuariosbytipo($tipousuario, $cantidadRegistros);";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	//metodo para contar usuarios por tipo de usuario
	public function contarbytipo($tipousuario) {
		$this->query = "call usp_contarusuariosbytipo($tipousuario);";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function verificarDni($dni) {
		$this->query = "call usp_verificardniusuario('$dni');";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function verificarCorreo($correo) {
		$this->query = "call usp_verificarcorreousuario('$correo');";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function obtenerusuario($codigo) {
		$this->query = "call usp_obtenerusuario($codigo);";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function getlogin($correo, $clave) {
		$this->query = "call usp_getlogin('$correo', '$clave');";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function cambiarestado($codigousuario, $estado){
		$this->query = "call usp_cambiarestadousuario($codigousuario, $estado);";
      $this->execute_single_query();
      return $this->query;
	}

	public function buscarbyapellidosusuario($apellidos) {
		$this->query = "call usp_buscarbyapellidosusuario('$apellidos');";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function buscarbydniusuario($dni) {
		$this->query = "call usp_buscarbydniusuario('$dni');";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}

	public function listarestilistasactives() {
			$this->query = "call usp_listarestilistas();";
      $this->execute_query();
      $data = $this->rows ;
      return $data;
	}*/

}

	$OBJ_USUARIO = new ClassUsuario();

?>
