<?php

    class ClassTipoCosecha extends Conexion {

        //constructor de la clase
        public function __construct(){

        }

        public function show($estado){

            $conexionClass = new Conexion();
            $conexion = $conexionClass->Open();
            $VD;

            try{

                $parametros = [];
                $sql = "SELECT * FROM `tb_tipo_cosecha` t WHERE 1 = 1";
                if($estado!="all"){
                    $sql .= " AND t.estado = ?";
                    $parametros[] = $estado;
                }
                $stmt = $conexion->prepare($sql);
                $stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!$result || count($result) == 0) {
					throw new Exception("No se encontraron datos.");
				}
				
                $VD1['error'] = "NO";
                $VD1['message'] = "Success";
                $VD1['data'] = $result;
                $VD = $VD1;

            } catch(Exception $e) {
				$VD1['error'] = "SI";
				$VD1['message'] = $e->getMessage();
				$VD = $VD1;

        } finally {
                $conexionClass->Close();
        }

        return $VD;
        }

        public function insert($descripcion,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_tipo_cosecha (id_tipo_cosecha, descripcion, estado) VALUES ((SELECT CASE COUNT(t.id_tipo_cosecha) WHEN 0 THEN 1 ELSE (MAX(t.id_tipo_cosecha) + 1) end FROM `tb_tipo_cosecha` t),?,?)");
				$stmt->execute([$descripcion,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
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

        public function update($id_tipo_cosecha,$descripcion,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_tipo_cosecha SET descripcion = ?, estado = ? WHERE id_tipo_cosecha = ?");
				$stmt->execute([$descripcion,$estado,$id_tipo_cosecha]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al actualizar los datos.");
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

        public function delete($id_tipo_cosecha) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_tipo_cosecha WHERE id_tipo_cosecha= ?");
				$stmt->execute([$id_tipo_cosecha]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
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

    $OBJ_TIPO_COSECHA = new ClassTipoCosecha();

?>