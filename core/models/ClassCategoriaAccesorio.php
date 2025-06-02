<?php

	class ClassCategoriaAccesorio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_categoria_accesorio` c WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND c.estado = ?";
					$parametros[] = $estado;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos.");
				}

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			} catch(PDOException $e) {

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

		public function insert($name_categoria,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_categoria_accesorio (id_categoria, name_categoria, estado) VALUES ((SELECT CASE COUNT(c.id_categoria) WHEN 0 THEN 1 ELSE (MAX(c.id_categoria) + 1) end FROM `tb_categoria_accesorio` c),?,?)");
				$stmt->execute([$name_categoria,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Categoría de Producto", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

		public function update($id_categoria,$name_categoria,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_categoria_accesorio SET name_categoria = ?, estado = ? WHERE id_categoria = ?");
				$stmt->execute([$name_categoria,$estado,$id_categoria]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Categoría de Producto", "Actualizar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

		public function delete($id_categoria) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_categoria = ?");
				$stmt->execute([$id_categoria]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Productos.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_categoria_accesorio WHERE id_categoria = ?");
				$stmt->execute([$id_categoria]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Categoría de Producto", "Eliminar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	}

	$OBJ_CATEGORIA_ACCESORIO = new ClassCategoriaAccesorio();

?>
