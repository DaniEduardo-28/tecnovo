<?php

class ClassCita extends Conexion
{

	//constructor de la clase
	public function __construct()
	{

	}

	public function showCitas($id_trabajador, $id_documento, $valor, $id_sucursal)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$parametros = null;
			$valor = "%$valor%";

			$sql = "SELECT M.*,C.id_cita,C.id_trabajador as id_medico,C.id_servicio,C.fecha_registro as fecha_registro_cita,
								C.fecha_cita,C.fecha_termino as fecha_termino_cita,C.sintoma as sintoma_cita,C.observaciones as observaciones_cita,
								C.mensaje_cita,C.estado as estado_cita,T.nombres_trabajador,T.apellidos_trabajador,S.name_servicio
								FROM vw_mascotas M
								INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota
								INNER JOIN vw_trabajadores T on T.id_trabajador = C.id_trabajador
								INNER JOIN tb_servicio S ON S.id_servicio = C.id_servicio
								WHERE (M.num_documento LIKE ? OR M.nombres LIKE ? OR M.apellidos LIKE ? ) AND C.id_sucursal = ?";

			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $id_sucursal;

			if ($id_documento != "all") {
				$sql .= " AND M.id_documento = ? ";
				$parametros[] = $id_documento;
			}

			if ($id_trabajador != "all") {
				$sql .= " AND C.id_trabajador = ? ";
				$parametros[] = $id_trabajador;
			}

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

	public function showCitasTrabajador($id_sucursal, $id_trabajador)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT M.*,C.id_cita,C.id_trabajador as id_medico,C.id_servicio,C.fecha_registro as fecha_registro_cita,
								C.fecha_cita,C.fecha_termino as fecha_termino_cita,C.sintoma as sintoma_cita,C.observaciones as observaciones_cita,
								C.mensaje_cita,C.estado as estado_cita,T.nombres_trabajador,T.apellidos_trabajador,S.name_servicio
								FROM vw_mascotas M
								INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota
								INNER JOIN vw_trabajadores T on T.id_trabajador = C.id_trabajador
								INNER JOIN tb_servicio S ON S.id_servicio = C.id_servicio
								WHERE C.id_trabajador = ? AND C.id_sucursal = ? AND (C.estado = 'aceptada' OR C.estado = 'registrada')";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador, $id_sucursal]);
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

	public function registrarCitaCliente($id_mascota, $id_trabajador, $id_cliente, $id_servicio, $fecha_1, $fecha_2, $sintomas, $id_sucursal)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM tb_mascota WHERE id_mascota = ? AND id_cliente = ?");
			$stmt->execute([$id_mascota, $id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No tienes permisos para registrar cita, con esta mascota.", 1);
			}

			$sql = "INSERT INTO tb_cita (`id_cita`, `id_trabajador`, `id_servicio`, `id_mascota`, `fecha_registro`, `fecha_cita`, `fecha_termino`, `sintoma`, `estado`, `id_sucursal`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(a.id_cita) WHEN 0 THEN 1 ELSE (MAX(a.id_cita) + 1) end FROM `tb_cita` a),";
			$sql .= "?,?,?,now(),?,?,?,?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador, $id_servicio, $id_mascota, $fecha_1, $fecha_2, $sintomas, "registrada", $id_sucursal]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$sql = "INSERT INTO tb_detalle_cita (`id_detalle`, `id_cita`, `name_servicio`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(a.id_detalle) WHEN 0 THEN 1 ELSE (MAX(a.id_detalle) + 1) end FROM `tb_detalle_cita` a),";
			$sql .= "(SELECT MAX(id_cita) FROM tb_cita),(SELECT name_servicio FROM tb_servicio WHERE id_servicio = ?)";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_servicio]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	public function registrarCitaAdmin($id_mascota, $id_trabajador, $id_servicio, $fecha_1, $fecha_2, $sintomas, $id_sucursal)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_cita (`id_cita`, `id_trabajador`, `id_servicio`, `id_mascota`, `fecha_registro`, `fecha_cita`, `fecha_termino`, `sintoma`, `estado`, `id_sucursal`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(a.id_cita) WHEN 0 THEN 1 ELSE (MAX(a.id_cita) + 1) end FROM `tb_cita` a),";
			$sql .= "?,?,?,now(),?,?,?,?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador, $id_servicio, $id_mascota, $fecha_1, $fecha_2, $sintomas, "registrada", $id_sucursal]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$sql = "INSERT INTO tb_detalle_cita (`id_detalle`, `id_cita`, `name_servicio`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(a.id_detalle) WHEN 0 THEN 1 ELSE (MAX(a.id_detalle) + 1) end FROM `tb_detalle_cita` a),";
			$sql .= "(SELECT MAX(id_cita) FROM tb_cita),(SELECT name_servicio FROM tb_servicio WHERE id_servicio = ?)";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_servicio]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	public function cancelar($id_cita, $id_cliente)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT C.* FROM `tb_cita` C INNER JOIN tb_mascota M ON M.id_mascota = C.id_mascota WHERE C.id_cita = ? AND M.id_cliente = ?");
			$stmt->execute([$id_cita, $id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No tienes permisos para cancelar esta cita.");
			}

			$sql = "UPDATE tb_cita SET estado = ? where id_cita = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute(["cancelada", $id_cita]) == false) {
				throw new Exception("Ocurrió un error al canclar la cita en el sistema.");
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

	public function actualizarCita($id_cita, $id_cliente, $fecha_1, $fecha_2)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT M.* FROM tb_mascota M INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota WHERE C.id_cita = ? AND M.id_cliente = ?");
			$stmt->execute([$id_cita, $id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No tienes permisos para actualizar cita, con esta mascota.", 1);
			}

			$sql = "UPDATE tb_cita SET fecha_cita = ?, fecha_termino = ? WHERE id_cita = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$fecha_1, $fecha_2, $id_cita]) == false) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	public function actualizarFechaCita($id_cita, $fecha_1, $fecha_2)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$sql = "UPDATE tb_cita SET fecha_cita = ?, fecha_termino = ? WHERE id_cita = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$fecha_1, $fecha_2, $id_cita]) == false) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	public function actualizarEstado($id_cita, $estado)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$sql = "UPDATE tb_cita SET estado = ? where id_cita = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$estado, $id_cita]) == false) {
				throw new Exception("Ocurrió un error al actualizar el estado de la cita en el sistema.");
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

	public function getOperadorPorMaquinaria($id_maquinaria)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT T.id_trabajador, CONCAT(P.nombres, ' ', P.apellidos) AS nombre
						FROM tb_trabajador T
						INNER JOIN tb_maquinaria M ON M.id_trabajador = T.id_trabajador
						INNER JOIN tb_persona P ON P.id_persona = T.id_persona
						WHERE M.id_maquinaria = ? AND T.estado = 'activo'";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_maquinaria]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron operadores para la maquinaria.");
			}

			$VD['error'] = "NO";
			$VD['message'] = "Operador encontrado.";
			$VD['data'] = $result;

		} catch (Exception $e) {
			$VD['error'] = "SI";
			$VD['message'] = $e->getMessage();
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}
	public function showreporte($estado, $fecha_inicio, $fecha_fin, $val, $tipobusqueda, $chkfechas)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));
			$fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+ 0 days"));

			$parametros = [];
			$sql = "SELECT c.id_cita, c.fecha_cita, c.estado, dc.name_servicio, 
CONCAT(p.nombres, ' ', p.apellidos) AS nombre_trabajador,
m.descripcion AS name_maquinaria
FROM tb_cita c 
INNER JOIN tb_detalle_cita dc ON dc.id_cita = c.id_cita
INNER JOIN tb_trabajador t ON t.id_trabajador = c.id_trabajador
INNER JOIN tb_persona p ON p.id_persona = t.id_persona
INNER JOIN tb_maquinaria m ON m.id_trabajador = t.id_trabajador
WHERE 1+1 AND t.flag_medico=1";

			if ($chkfechas == 'true') {
				$sql .= " AND DATE(c.fecha_cita) BETWEEN ? AND ?";
				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
			}

			if (!empty($val)) {
				if ($tipobusqueda == 1) {
					$sql .= " AND dc.name_servicio = ?";
					$parametros[] = $val;
				} elseif ($tipobusqueda == 2) {
					$sql .= " AND nombre_trabajador = ?";
					$parametros[] = $val;
				}
			}
			// Orden
			$sql .= " ORDER BY c.fecha_cita DESC";
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


}

$OBJ_CITA = new ClassCita();

?>