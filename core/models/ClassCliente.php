<?php

class ClassCliente extends Conexion
{

	//constructor de la clase
	public function __construct()
	{
	}

	public function getCount($estado, $id_documento, $valor)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad FROM `tb_persona` p
							  INNER JOIN tb_cliente c ON c.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";

			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;

			if ($estado != "all") {
				$sql .= " AND c.estado = ?";
				$parametros[] = $estado;
			}
			if ($id_documento != "") {
				$sql .= " AND p.id_documento = ?";
				$parametros[] = $id_documento;
			}

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos");
			} else {
				if ($result[0]['cantidad'] == 0) {
					throw new Exception("No se encontraron datos.");
				}
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function show($estado, $id_documento, $valor, $offset, $limit)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$valor = "%$valor%";
			$parametros = null;
			$parametros = null;
			$sql = "SELECT p.*,c.id_cliente,c.name_user,
								c.pass_user,c.estado,d.name_documento,c.src_imagen
								FROM `tb_persona` p
								INNER JOIN tb_documento_identidad d ON d.id_documento = p.id_documento
							  INNER JOIN tb_cliente c ON c.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;
			if ($estado != "all") {
				$sql .= " AND c.estado = ?";
				$parametros[] = $estado;
			}
			if ($id_documento != "") {
				$sql .= " AND p.id_documento = ?";
				$parametros[] = $id_documento;
			}

			$sql .= " LIMIT $offset, $limit ";

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}


	public function listarClientes()
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT * FROM vw_clientes ORDER BY apellidos_cliente ASC";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function getDataEditCliente($id_cliente)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT p.*,c.id_cliente,c.name_user,
								c.pass_user,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_cliente c ON c.id_persona = p.id_persona
								WHERE  c.id_cliente = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function insert($id_persona, $id_cliente, $id_documento, $num_documento, $nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento, $sexo, $estado, $flag_imagen, $src_imagen, $apodo)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
			$stmt->execute([$id_documento, $num_documento]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_persona = 0;

			if (count($result) > 0) {

				$id_persona = $result[0]['id_persona'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona = ? ");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El cliente ya se encuentra registrado en el sistema.");
				}

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
					$stmt->execute([$id_persona, $correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$sql = "UPDATE tb_persona SET ";
				$sql .= " nombres = ?, ";
				$sql .= " apellidos = ?, ";
				$sql .= " direccion = ?, ";
				$sql .= " correo = ?, ";
				$sql .= " telefono = ?, ";
				$sql .= " fecha_nacimiento = ?, ";
				$sql .= " apodo = ?, ";
				$sql .= " sexo = ? ";
				$sql .= " WHERE id_persona = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento, $apodo, $sexo, $id_persona]) == false) {
					throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
				}
			} else {

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
					$stmt->execute([$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `apodo`, `sexo`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
				$sql .= "?,?,?,?,?,?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_documento, $num_documento, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha_nacimiento, $apodo, $sexo]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("1. Error al registrar los datos del cliente.");
				}

				$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0) {
					throw new Exception("Error al seleccionar el id del cliente.");
				}

				$id_persona = $result[0]['id_persona'];
			}

			$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
			$sql .= "?,now(),?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_persona, $estado, $src_imagen]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al registrar el cliente en la base de datos.");
			}

			$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([]) == false) {
				throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function getDataClienteForDocumento($id_documento, $num_documento)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT p.*,c.id_cliente,c.name_user,
								c.pass_user,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_cliente c ON c.id_persona = p.id_persona
								WHERE  p.id_documento = ? and p.num_documento = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_documento, $num_documento]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function update($id_persona, $id_cliente, $id_documento, $num_documento, $nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento, $sexo, $estado, $flag_imagen, $src_imagen, $apodo)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona = ?");
			$stmt->execute([$id_persona]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("1. No se encontró el registro del cliente a editar.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_cliente = ?");
			$stmt->execute([$id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("2. No se encontró el registro del cliente a editar.");
			}

			if (trim($correo) != "") {
				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
				$stmt->execute([$id_persona, $correo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El correo ya se encuentra registrado en el sistema.");
				}
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND id_documento = ? AND num_documento = ?");
			$stmt->execute([$id_persona, $id_documento, $num_documento]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) > 0) {
				throw new Exception("El Número de documento ya se encuentra registrado en el sistema.");
			}

			$sql = "UPDATE tb_persona SET ";
			$sql .= " id_documento = ?, ";
			$sql .= " num_documento = ?, ";
			$sql .= " nombres = ?, ";
			$sql .= " apellidos = ?, ";
			$sql .= " direccion = ?, ";
			$sql .= " correo = ?, ";
			$sql .= " telefono = ?, ";
			$sql .= " fecha_nacimiento = ?, ";
			$sql .= " apodo = ?, ";
			$sql .= " sexo = ? ";
			$sql .= " WHERE id_persona = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_documento, $num_documento, $nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento, $apodo, $sexo, $id_persona]) == false) {
				throw new Exception("1. Error al actualizar los datos del cliente.");
			}

			$sql = "UPDATE tb_cliente SET ";
			$sql .= " estado = ? ";
			$sql .= " WHERE id_cliente = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$estado, $id_cliente]) == false) {
				throw new Exception("2. Error al actualizar los datos del cliente.");
			}

			if ($flag_imagen == "1") {
				$stmt = $conexion->prepare("UPDATE tb_cliente SET src_imagen = ? WHERE id_cliente = ?");
				if ($stmt->execute([$src_imagen, $id_cliente]) == false) {
					throw new Exception("Error al registrar la imagen del cliente.");
				}
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function delete($id_cliente)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {
			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_mascota` WHERE id_cliente = ?");
			$stmt->execute([$id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) > 0) {
				throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Operaciones.");
			}

			$stmt = $conexion->prepare("DELETE FROM tb_cliente WHERE id_cliente = ?");
			$stmt->execute([$id_cliente]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("2. Ocurrió un error al eliminar el registro.");
			}

			$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int - 1 where id_parametro = 25";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([]) == false) {
				throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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


	public function addPromocion($id_cliente, $titulo, $descripcion, $fecha_inicio, $fecha_fin, $src_imagen)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_promocion (`id_promocion`, `id_cliente`, `titulo`, `descripcion`, `precio`, `fecha_inicio`, `fecha_fin`, `src_imagen`, `estado`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(c.id_promocion) WHEN 0 THEN 1 ELSE (MAX(c.id_promocion) + 1) end FROM `tb_promocion` c),";
			$sql .= "?,?,?,?,?,?,?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_cliente, $titulo, $descripcion, 0, $fecha_inicio, $fecha_fin, $src_imagen, "1"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al registrar la promoción en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function showPromocionesCliente($id_cliente)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_actual = date('Y-m-d');
			$sql = "SELECT * FROM tb_promocion WHERE id_cliente = ? AND estado = '1' AND fecha_fin >= ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_cliente, $fecha_actual]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron promociones registradas.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;
		} catch (Exception $exception) {

			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function deletePromocion($id_promocion)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("UPDATE tb_promocion SET estado = '0' WHERE id_promocion = ?");
			$stmt->execute([$id_promocion]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("1. Ocurrió un error al eliminar el registro.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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
}

$OBJ_CLIENTE = new ClassCliente();
