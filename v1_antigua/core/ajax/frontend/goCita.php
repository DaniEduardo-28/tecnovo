<?php

  $id_mascota = isset($_POST["id_mascota"]) ? $_POST["id_mascota"] : 0;
  $id_trabajador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : 0;
  $id_fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : 0;
  $name_sucursal = isset($_POST["name_sucursal"]) ? $_POST["name_sucursal"] : "";
  $id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : 0;
  $id_servicio = isset($_POST["cboServicioForm"]) ? $_POST["cboServicioForm"] : 0;
  $fecha_inicio = isset($_POST["txtFechaInicio"]) ? $_POST["txtFechaInicio"] : 0;
  $hora_inicio = isset($_POST["txtHoraInicio"]) ? $_POST["txtHoraInicio"] : 0;
  $fecha_fin = isset($_POST["txtFechaTermino"]) ? $_POST["txtFechaTermino"] : 0;
  $hora_fin = isset($_POST["txtHoraFin"]) ? $_POST["txtHoraFin"] : 0;
  $sintomas = isset($_POST["txtSintomas"]) ? $_POST["txtSintomas"] : 0;

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($id_mascota==0) {
      throw new Exception("Campo obligatorio : Seleccionar Mascota");
    }

    if ($id_fundo==0) {
      throw new Exception("Campo obligatorio : Seleccionar una sucursal.");
    }

    if ($id_trabajador==0) {
      throw new Exception("Campo obligatorio : Seleccionar Usuario de Cita..");
    }

    if ($id_servicio==0) {
      throw new Exception("Campo obligatorio : Seleccionar el servicio de atención.");
    }

    if ($id_cliente==0) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
    $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

    require_once "admin/core/models/ClassCita.php";
    $VD = $OBJ_CITA->registrarCitaCliente($id_mascota,$id_trabajador,$id_cliente,$id_servicio,$fecha_1,$fecha_2,$sintomas,$id_fundo);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    // Varios destinatarios
    $para  = CORREO_RECIBE; // atención a la coma
    // título
    $titulo = 'Reserva de cita';

    // mensaje
    $mensaje = '
    <html>
    <head>
      <title>Reserva de Cita en el sistema</title>
    </head>
    <body>
      <h3 style="text-align : center;">' . APP_TITLE . '</h3>
      <table>
        <tr>
          <th style="text-align : center;">Descripción</th><th style="text-align : center;">Datos de Cita</th>
        </tr>
        <tr>
          <td>Sucursal</td><td>' . $name_sucursal . '</td>
        </tr>
        <tr>
          <td>Cliente</td><td>' . $_SESSION['apellidos_cliente'] . ', ' . $_SESSION['nombres_cliente'] . '</td>
        </tr>
        <tr>
          <td>Fecha de cita </td><td>' . date('d/m/Y H:i', strtotime($fecha_1)) . '</td>
        </tr>
        <tr>
          <td>Síntomas </td><td>' . $sintomas . '</td>
        </tr>
      </table>
    </body>
    </html>
    ';

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // send the email
    if(!mail($para, $titulo, $mensaje, $cabeceras)){
      throw new Exception("La cita se registró correctamente en el sistema, pero ocurrió un error al enviar el correo electrónico de aviso al administrador.");
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
