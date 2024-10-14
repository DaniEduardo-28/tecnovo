<?php

    class ClassOrdenGasto extends Conexion {

        //constructor de la clase
        public function __construct() {

        }

        public function getCount($id_gasto,$valor,$fecha_gasto,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$fecha_gasto = date("Y-m-d",strtotime($fecha_gasto));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` o
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_gasto >= ? AND o.id_proveedor = ? ";

				$parametros[] = $fecha_gasto;
				$parametros[] = $id_gasto;

				if ($tipo_busqueda!='') {
					switch ($tipo_busqueda) {
						case "1":
							$sql .= " AND p.num_documento_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						case "2":
							$sql .= " AND p.nombre_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						default:
							break;
					}
				}

			$stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0 || $result[0]['cantidad'] == 0) {
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

    public function show($id_gasto,$valor,$fecha_gasto,$tipo_busqueda,$offset,$limit) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $fecha_gasto = date("Y-m-d",strtotime($fecha_gasto));

            $valor = "%$valor%";
            $parametros = null;
            $sql = "SELECT o.*, p.nombre_proveedor, g.name_gasto, m.signo as signo_moneda, 
                    (SELECT SUM(dc.precio_unit * dc.cantidad_solicitada) FROM tb_detalle_gasto dc 
                    WHERE dc.id_orden_gasto = o.id_orden_gasto) AS total 
                    FROM `tb_orden_gasto` o 
                    INNER JOIN tb_moneda m ON m.id_moneda = o.id_moneda 
                    INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor 
                    INNER JOIN tb_gasto g ON g.id_gasto = o.id_gasto 
                    WHERE o.fecha_gasto >= ? AND o.id_proveedor = ? ";

            $parametros[] = $fecha_gasto;
            $parametros[] = $id_gasto;

            if ($tipo_busqueda!='') {
                switch ($tipo_busqueda) {
                    case 1:
                        $sql .= " AND p.num_documento_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    case 2:
                        $sql .= " AND p.nombre_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    default:
                        break;
                }
            }

            $sql .= " LIMIT $offset, $limit";


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

    public function getCount1($id_gasto,$valor,$fecha_gasto,$tipo_busqueda) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $fecha_gasto = date("Y-m-d",strtotime($fecha_gasto));

            $valor = "%$valor%";
            $parametros = null;
            $sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` o
                            INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
                            WHERE o.fecha_gasto >= ?
                            AND o.id_proveedor = ? ";

            $parametros[] = $fecha_gasto;
            $parametros[] = $id_gasto;

            if ($tipo_busqueda!='') {
                switch ($tipo_busqueda) {
                    case "1":
                        $sql .= " AND p.num_documento_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    case "2":
                        $sql .= " AND p.nombre_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    default:
                        break;
                }
            }

            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontraron datos");
            }else {
                if ($result[0]['cantidad']==0) {
                    throw new Exception("No se encontraron datos.");
                }
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

    public function show1($id_gasto,$valor,$fecha_gasto,$tipo_busqueda,$offset,$limit) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $fecha_gasto = date("Y-m-d",strtotime($fecha_gasto));

            $valor = "%$valor%";
            $parametros = null;
            $sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,mon.signo as signo_moneda,
                            FROM `tb_orden_gasto` o
                            INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
                            INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
                            INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
                            WHERE o.fecha_orden >= ?
                            AND o.id_proveedor = ? ";

            $parametros[] = $fecha_gasto;
            $parametros[] = $id_gasto;

            if ($tipo_busqueda!='') {
                switch ($tipo_busqueda) {
                    case 1:
                        $sql .= " AND p.num_documento_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    case 2:
                        $sql .= " AND p.nombre_proveedor LIKE ? ";
                        $parametros[] = $valor;
                        break;
                    default:
                        break;
                }
            }

            $sql .= " LIMIT $offset, $limit";

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

    public function getDataEditOrdenGasto($id_orden_gasto) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
            $stmt->execute([$id_orden_gasto]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
            }

            $sql = "SELECT * FROM vw_orden_gasto
                            WHERE id_orden_gasto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_orden_gasto]);
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

    public function getDataVerOrdenGasto($id_orden_gasto) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $sql = "SELECT * FROM vw_orden_gasto
                            WHERE id_orden_gasto = ? ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_orden_gasto]);
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

    public function getCountDetalleParaOrden($valor) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD= " ";

        try {

            $valor = "%$valor%";
            $sql = "";
            $parametros = null;
            $sql .= "SELECT count(*) as cantidad FROM tb_gasto WHERE name_gasto LIKE ? ";
                    
                    $parametros[] = $valor;
            

            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontraron datos");
            }else {
                if ($result[0]['cantidad']==0) {
                    throw new Exception("No se encontraron datos.");
                }
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

    public function getDataPrintOrdenGasto($id_orden_gasto) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD= "";

        try {

            $sql = "SELECT * FROM vw_orden_gasto
                            WHERE id_orden_gasto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_orden_gasto]);
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

    public function getDataEditOrdenGastoIngreso($id_orden_gasto) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
            $stmt->execute([$id_orden_gasto]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
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

    public function showDetalleParaOrden($valor,$offset,$limit) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $valor = "%$valor%";
            $sql = "";
            $parametros = null;

            $sql .= "SELECT name_gasto as descripcion,id_gasto
                                    FROM tb_gasto WHERE name_gasto LIKE ? ";
                    $parametros[] = $valor;
            
            $sql .= " LIMIT $offset, $limit ";

            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontraron datos");
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

    public function insert($id_proveedor,$id_orden_gasto,$id_gasto,$id_trabajador,$codigo_moneda,$fecha_gasto,$descripcion,$observaciones) {

        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
        try {

            $conexion->beginTransaction();

            $sql = "INSERT INTO tb_orden_gasto (`id_orden_gasto`, `id_proveedor`, `id_trabajador`, `id_gasto`, `fecha_gasto`, `descripción`, `observaciones`, `id_moneda`) VALUES ";
            $sql .= "(";
            $sql .= "(SELECT CASE COUNT(o.id_orden_gasto) WHEN 0 THEN 1 ELSE (MAX(o.id_orden_gasto) + 1) end FROM `tb_orden_gasto` o),";
            $sql .= "?,?,?,?,?,NOW(),?,?,?,?,?";
            $sql .= ")";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_proveedor,$id_gasto,$id_gasto,$id_trabajador,$fecha_gasto,$descripcion,$observaciones,'0',$codigo_moneda]);
            if ($stmt->rowCount()==0) {
                throw new Exception("1. Error al registrar la orden de gasto en la base de datos.");
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

    public function update($id_orden_gasto,$id_proveedor,$id_trabajador,$id_gasto,$codigo_moneda,$fecha_gasto,$descripcion,$observaciones) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
        try {

            $conexion->beginTransaction();

            $stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
            $stmt->execute([$id_orden_gasto]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
            }

            $sql = "UPDATE tb_orden_gasto SET ";
            $sql .=" id_gasto = ?, ";
            $sql .=" id_proveedor = ?, ";
            $sql .=" id_trabajador = ?, ";
            $sql .=" fecha_gasto = ?, ";
            $sql .=" id_moneda = ?, ";
            $sql .=" descripcion = ? ";
            $sql .=" observaciones = ? ";
            $sql .=" WHERE id_orden_gasto = ? ";
            $stmt = $conexion->prepare($sql);
            if ($stmt->execute([$id_gasto,$id_proveedor,$id_trabajador,$fecha_gasto,$codigo_moneda,$descripcion,$observaciones,$id_orden_gasto])==false) {
                throw new Exception("1. Error al actualizar los datos de la orden de gasto.");
            }

            $stmt = $conexion->prepare("DELETE FROM tb_detalle_gasto WHERE id_orden_gasto = ?");
            $stmt->execute([$id_orden_gasto]);
            if ($stmt->rowCount()==0) {
                throw new Exception("2. Ocurrió un error al actualizar el detalle de la orden.");
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

    public function delete($id_orden_gasto) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
        try {

            $conexion->beginTransaction();

            $stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
            $stmt->execute([$id_orden_gasto]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0) {
                throw new Exception("No se encontró la orden a anular.");
            }

            $stmt = $conexion->prepare("UPDATE tb_orden_gasto WHERE id_orden_gasto = ?");
            $stmt->execute([$id_orden_gasto]);
            if ($stmt->rowCount()==0) {
                throw new Exception("2. Ocurrió un error al anular la orden.");
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
$OBJ_ORDEN_GASTO = new ClassOrdenGasto();

?>
