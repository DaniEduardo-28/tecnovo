<?php
class ClassOrdenGasto extends Conexion
{

	// Constructor
	public function __construct()
	{
		parent::__construct(); // Invoca al constructor de la clase padre, si es necesario
	}

	// Método para insertar una nueva orden de gasto
	public function insert($data)
	{
		$conexion = $this->Open();
		try {
			$conexion->beginTransaction();
			$sql = "INSERT INTO tb_orden_gasto (id_documento, id_documento_venta, id_moneda, id_proveedor, id_gasto, id_servicio, serie, correlativo, fecha_gasto) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([
				$data['id_documento'],
				$data['id_documento_venta'],
				$data['id_moneda'],
				$data['id_proveedor'],
				$data['id_gasto'],
				$data['id_servicio'],
				$data['serie'],
				$data['correlativo'],
				$data['fecha_gasto']
			]);

			$conexion->commit();
			return ["error" => "NO", "message" => "Registro insertado exitosamente"];
		} catch (PDOException $e) {
			$conexion->rollBack();
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}

	// Método para actualizar una orden de gasto existente
	public function update($id_orden_gasto, $data)
	{
		$conexion = $this->Open();
		try {
			$conexion->beginTransaction();
			$sql = "UPDATE tb_orden_gasto 
                    SET id_documento = ?, id_documento_venta = ?, id_moneda = ?, id_proveedor = ?, 
                        id_gasto = ?, id_servicio = ?, serie = ?, correlativo = ?, fecha_gasto = ? 
                    WHERE id_orden_gasto = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([
				$data['id_documento'],
				$data['id_documento_venta'],
				$data['id_moneda'],
				$data['id_proveedor'],
				$data['id_gasto'],
				$data['id_servicio'],
				$data['serie'],
				$data['correlativo'],
				$data['fecha_gasto'],
				$id_orden_gasto
			]);

			$conexion->commit();
			return ["error" => "NO", "message" => "Registro actualizado exitosamente"];
		} catch (PDOException $e) {
			$conexion->rollBack();
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}

	// Método para eliminar una orden de gasto (se podría usar un flag de anulación en lugar de eliminar físicamente)
	public function delete($id_orden_gasto)
	{
		$conexion = $this->Open();
		try {
			$conexion->beginTransaction();
			$sql = "DELETE FROM tb_orden_gasto WHERE id_orden_gasto = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_orden_gasto]);

			$conexion->commit();
			return ["error" => "NO", "message" => "Registro eliminado exitosamente"];
		} catch (PDOException $e) {
			$conexion->rollBack();
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}

	public function getDataEditOrdenGasto($id_orden_gasto)
	{
		$conexion = $this->Open();
		try {
			// Consulta para obtener los datos de la orden de gasto
			$sql = "SELECT og.id_orden_gasto, og.id_proveedor, p.nombre AS nombre_proveedor, p.imagen AS src_imagen_proveedor,
						   og.fecha_gasto, og.observaciones, og.id_moneda, 
						   dg.cod_producto AS cod_gasto, dg.name_tabla, dg.cantidad_solicitada, dg.precio_unitario,
						   (dg.cantidad_solicitada * dg.precio_unitario) AS total
					FROM tb_orden_gasto AS og
					INNER JOIN tb_detalle_gasto AS dg ON dg.id_orden_gasto = og.id_orden_gasto
					INNER JOIN tb_proveedor AS p ON p.id_proveedor = og.id_proveedor
					WHERE og.id_orden_gasto = ?";

			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) === 0) {
				throw new Exception("No se encontró la orden de gasto solicitada.");
			}

			return ["error" => "NO", "data" => $result];
		} catch (PDOException $e) {
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}

	public function getCount($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda) {
		$conexion = $this->Open();
		try {
			// Ajusta el rango de fechas
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));
	
			// Parámetros y consulta SQL
			$parametros = [];
			$sql = "SELECT COUNT(*) AS cantidad 
					FROM tb_orden_gasto og
					INNER JOIN tb_proveedor p ON p.id_proveedor = og.id_proveedor
					WHERE og.fecha_gasto >= ? AND og.fecha_gasto < ?";
	
			// Agrega parámetros de fecha
			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;
	
			// Filtra según el tipo de búsqueda
			if ($tipo_busqueda != '') {
				$valor = "%$valor%";
				if ($tipo_busqueda == "1") {
					$sql .= " AND p.num_documento_proveedor LIKE ?";
				} elseif ($tipo_busqueda == "2") {
					$sql .= " AND p.nombre_proveedor LIKE ?";
				}
				$parametros[] = $valor;
			}
	
			// Ejecuta la consulta
			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
			if (!$result) {
				throw new Exception("No se encontraron datos.");
			}
	
			return ["error" => "NO", "data" => [$result]];
		} catch (PDOException $e) {
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}

	public function show($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda, $offset, $limit) {
		$conexion = $this->Open();
		try {
			// Ajusta el rango de fechas
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));
	
			// Parámetros y consulta SQL
			$parametros = [];
			$sql = "SELECT og.id_orden_gasto, og.fecha_gasto, p.nombre AS nombre_proveedor, 
						   u.nombres AS nombres_trabajador, m.signo AS signo_moneda, 
						   COUNT(dg.id_detalle) AS num_registros, 
						   SUM(dg.cantidad_solicitada * dg.precio_unitario) AS total
					FROM tb_orden_gasto og
					INNER JOIN tb_proveedor p ON p.id_proveedor = og.id_proveedor
					INNER JOIN tb_moneda m ON m.id_moneda = og.id_moneda
					LEFT JOIN tb_detalle_gasto dg ON dg.id_orden_gasto = og.id_orden_gasto
					LEFT JOIN tb_usuario u ON u.id_usuario = og.id_usuario
					WHERE og.fecha_gasto >= ? AND og.fecha_gasto < ?";
	
			// Agrega parámetros de fecha
			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;
	
			// Filtra según el tipo de búsqueda
			if ($tipo_busqueda != '') {
				$valor = "%$valor%";
				if ($tipo_busqueda == "1") {
					$sql .= " AND p.num_documento_proveedor LIKE ?";
				} elseif ($tipo_busqueda == "2") {
					$sql .= " AND p.nombre_proveedor LIKE ?";
				}
				$parametros[] = $valor;
			}
	
			$sql .= " GROUP BY og.id_orden_gasto 
					  ORDER BY og.fecha_gasto DESC 
					  LIMIT $offset, $limit";
	
			// Ejecuta la consulta
			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
			if (count($result) === 0) {
				throw new Exception("No se encontraron datos.");
			}
	
			return ["error" => "NO", "data" => $result];
		} catch (PDOException $e) {
			return ["error" => "SI", "message" => $e->getMessage()];
		} finally {
			$this->Close();
		}
	}
	
	
}

// Instancia de la clase para pruebas (asegúrate de comentar o eliminar este bloque en producción)
$OBJ_ORDEN_GASTO = new ClassOrdenGasto();
