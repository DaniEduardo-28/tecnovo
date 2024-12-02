<?php



  $id_vacuna = isset($_POST["id_vacuna"]) ? $_POST["id_vacuna"] : "";
  $id_tipo_mascota = isset($_POST["id_tipo_mascota"]) ? $_POST["id_tipo_mascota"] : "";
  $name_vacuna = isset($_POST["name_vacuna"]) ? $_POST["name_vacuna"] : "";
  $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
  $edad_minima = isset($_POST["edad_minima"]) ? $_POST["edad_minima"] : 0;
  $edad_maxima = isset($_POST["edad_maxima"]) ? $_POST["edad_maxima"] : 0;
  $estado = isset($_POST["estado"]) ? 'activo' : 'inactivo';
  $tipo = isset($_POST["tipo_vacuna"]) ? '1' : '0';
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vacuna"));
    if ($access_options[0]['error']=="NO") {
      switch ($accion) {
        case 'add':
          if ($access_options[0]['flag_agregar']==false) {
            throw new Exception("No tienes permiso para agregar.");
          }
          break;
        case 'edit':
          if ($access_options[0]['flag_editar']==false) {
            throw new Exception("No tienes permiso para editar.");
          }
          break;
        default:
          throw new Exception("No se recibió el parametro de acción.");
          break;
      }
    }else {
      throw new Exception("Error al validar los permisos.");
    }

    if (empty(trim($name_vacuna))) {
      throw new Exception("Campo Obligatorio : Nombre de Vacuna.");
    }

    if (empty(trim($id_tipo_mascota))) {
      throw new Exception("Campo Obligatorio : Tipo de Operación.");
    }

    if (empty(trim($edad_minima))) {
      throw new Exception("Campo Obligatorio : Edad Mínima.");
    }

    if (empty(trim($edad_minima))) {
      throw new Exception("Campo Obligatorio : Edad Máxima.");
    }

    if ($edad_maxima<$edad_minima) {
      throw new Exception("La edad máxima no puede ser menor que la mínima.");
    }

    require_once "core/models/ClassVacuna.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_VACUNA->insert($id_vacuna,$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$estado,$tipo);
        break;
      case 'edit':
        $VD = $OBJ_VACUNA->update($id_vacuna,$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$estado,$tipo);
        break;
      default:
        $VD = "Tipo de Operación no encontrada.";
        break;
    }

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
