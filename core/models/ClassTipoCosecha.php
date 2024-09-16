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

                $parametros = null;
                $sql = "SELECT * FROM 'tb_tipo_cosecha' t WHERE 1 = 1";
                if($estado!="all"){
                    $sql .= " AND t.estado = ?";
                    $parametros[] = $estado;
                }
                $stmt = $conexion->prepare($sql);
                $stmt->execute($parametros);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if(count($result)==0) {
                    throw new Exception("No se encontraron datos.");
                }

                $VD1['error'] = "NO";
                $VD1['message'] = "Success";
                $VD1['data'] = $result;
                $VD = $VD1;

            } catch(Exception $e){

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

        public function insert($descripcion,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_tipo_cosecha (codigo, descripcion, estado) VALUES ((SELECT CASE COUNT(t.id_tipo_servicio) WHEN 0 THEN 1 ELSE (MAX(t.id_tipo_servicio) + 1) end FROM `tb_tipo_servicio` t),?,?)");
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
    }