<?php

class ClassServicio extends Conexion
{

	//constructor de la clase
	public function __construct() {}

	public function getCount($estado, $id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $valor)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT count(*) as cantidad FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.id_unidad_medida
								INNER JOIN tb_moneda M ON M.id_moneda = s.id_moneda
								WHERE (s.name_servicio LIKE ? OR s.descripcion_breve LIKE ?) ";

			$parametros[] = $valor;
			$parametros[] = $valor;

			if ($estado != "all") {
				$sql .= " AND s.estado = ?";
				$parametros[] = $estado;
			}
			if ($id_tipo_servicio != "") {
				$sql .= " AND s.id_tipo_servicio = ?";
				$parametros[] = $id_tipo_servicio;
			}
			if ($id_maquinaria != "") {
				$sql .= " AND s.id_maquinaria = ?";
				$parametros[] = $id_maquinaria;
			}
			if ($id_unidad_medida != "") {
				$sql .= " AND s.id_unidad_medida = ?";
				$parametros[] = $id_unidad_medida;
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

	public function show($estado, $id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $valor, $offset, $limit)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT s.*,t.name_tipo,q.descripcion AS maquinaria_descripcion,u.name_unidad AS unidad, M.name_moneda
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.id_unidad_medida
								INNER JOIN tb_moneda M ON M.id_moneda = s.id_moneda
								WHERE (s.name_servicio LIKE ? OR s.descripcion_breve LIKE ?) ";
			$parametros[] = $valor;
			$parametros[] = $valor;

			if ($estado != "all") {
				$sql .= " AND s.estado = ?";
				$parametros[] = $estado;
			}
			if ($id_tipo_servicio != "") {
				$sql .= " AND s.id_tipo_servicio = ?";
				$parametros[] = $id_tipo_servicio;
			}
			if ($id_maquinaria != "") {
				$sql .= " AND s.id_maquinaria = ?";
				$parametros[] = $id_maquinaria;
			}
			if ($id_unidad_medida != "") {
				$sql .= " AND s.id_unidad_medida = ?";
				$parametros[] = $id_unidad_medida;
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

	public function showMaquinas($estado_maquinaria = "all")
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$parametros = [];
			$sql = "SELECT q.id_maquinaria, q.descripcion AS maquinaria_descripcion
						FROM tb_maquinaria q";

			if ($estado_maquinaria === "activo") {
				$sql .= " WHERE q.estado = ?";
				$parametros[] = "activo";
			}

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// Agrega esta línea para verificar el resultado en el log de PHP
			error_log(print_r($result, true));

			$VD1['data'] = $result ? $result : [];
			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD = $VD1;
		} catch (PDOException $e) {
			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD1['data'] = [];
		} catch (Exception $exception) {
			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD1['data'] = [];
		} finally {
			$conexionClass->Close();
		}

		return $VD;
	}

	public function getDataEditServicio($id_servicio)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT s.*,t.name_tipo,q.descripcion AS maquinaria_descripcion,u.name_unidad AS unidad
								FROM tb_servicio s
								INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.id_unidad_medida
								WHERE  s.id_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_servicio]);
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

	public function insert($id_servicio, $id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $name_servicio, $descripcion_breve, $descripcion_larga, $precio, $pago_operador, $estado, $flag_imagen, $src_imagen, $id_moneda, $flag_igv)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_servicio (`id_servicio`, `id_tipo_servicio`, `id_maquinaria`,`id_unidad_medida`, `name_servicio`, `descripcion_breve`, `descripcion_larga`, `precio`, `pago_operador`, `src_imagen`, `estado`, `id_moneda`, `flag_igv`, `signo_moneda`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(s.id_servicio) WHEN 0 THEN 1 ELSE (MAX(s.id_servicio) + 1) end FROM `tb_servicio` s),";
			$sql .= "?,?,?,?,?,?,?,?,?,?,?,?,(SELECT M.signo FROM tb_moneda M WHERE M.id_moneda = ?)";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $name_servicio, $descripcion_breve, $descripcion_larga, $precio, $pago_operador, $src_imagen, $estado, $id_moneda, $flag_igv, $id_moneda]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al registrar el producto en la base de datos.");
			}

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Servicio", "Insertar"]);
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

	public function update($id_servicio, $id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $name_servicio, $descripcion_breve, $descripcion_larga, $precio, $pago_operador, $estado, $flag_imagen, $src_imagen, $id_moneda, $flag_igv)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_servicio` WHERE id_servicio = ?");
			$stmt->execute([$id_servicio]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("1. No se encontró el registro del servicio a editar.");
			}

			$sql = "UPDATE tb_servicio SET ";
			$sql .= " id_tipo_servicio = ?, ";
			$sql .= " id_maquinaria = ?, ";
			$sql .= " id_unidad_medida = ?, ";
			$sql .= " name_servicio = ?, ";
			$sql .= " descripcion_breve = ?, ";
			$sql .= " descripcion_larga = ?, ";
			$sql .= " estado = ?, ";
			$sql .= " flag_igv = ?, ";
			$sql .= " id_moneda = ?, ";
			$sql .= " signo_moneda = (SELECT M.signo FROM tb_moneda M WHERE M.id_moneda = ?), ";
			$sql .= " precio = ?, ";
			$sql .= " pago_operador = ? ";
			$sql .= " WHERE id_servicio = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_tipo_servicio, $id_maquinaria, $id_unidad_medida, $name_servicio, $descripcion_breve, $descripcion_larga, $estado, $flag_igv, $id_moneda, $id_moneda, $precio, $pago_operador, $id_servicio]) == false) {
				throw new Exception("1. Error al actualizar los datos del producto.");
			}

			if ($flag_imagen == "1") {
				$stmt = $conexion->prepare("UPDATE tb_servicio SET src_imagen = ? WHERE id_servicio = ?");
				if ($stmt->execute([$src_imagen, $id_servicio]) == false) {
					throw new Exception("Error al registrar la imagen del servicio.");
				}
			}

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Servicio", "Actualizar"]);
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

	public function delete($id_servicio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("DELETE FROM tb_servicio WHERE id_servicio = ?");
			$stmt->execute([$id_servicio]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al eliminar el registro.");
			}

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Servicios", "Eliminar"]);
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

	public function show_all()
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT s.*,t.name_tipo,q.descripcion AS maquinaria_descripcion,u.name_unidad AS unidad
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
							  INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
							  INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.id_unidad_medida";
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

	public function show_cantidad_limite_activos($cantidad)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT s.*,t.name_tipo,q.descripcion AS maquinaria_descripcion,u.name_unidad AS unidad
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
							  INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
							  INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.unidad_medida
								WHERE s.estado = 'activo'
								LIMIT $cantidad";
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

	public function show_activos()
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT s.*,t.name_tipo,q.descripcion AS maquinaria_descripcion,u.cod_sunat AS unidad
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
							  INNER JOIN tb_maquinaria q ON q.id_maquinaria = s.id_maquinaria
						       INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = s.id_unidad_medida

								WHERE s.estado = 'activo'";
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
}

$OBJ_SERVICIO = new ClassServicio();
