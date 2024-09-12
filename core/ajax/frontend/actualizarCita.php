<?php

  $id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : 0;
  $id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : 0;
  $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : date('Y-m-d');
  $hora_inicio = isset($_POST["hora_inicio"]) ? $_POST["hora_inicio"] : date('H:i');
  $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : date('Y-m-d');
  $hora_fin = isset($_POST["hora_fin"]) ? $_POST["hora_fin"] : date('H:i');

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($id_cita==0) {
      throw new Exception("Campo obligatorio : Id de Cita");
    }

    $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
    $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

    require_once "admin/core/models/ClassCita.php";
    $VD = $OBJ_CITA->actualizarCita($id_cita,$id_cliente,$fecha_1,$fecha_2);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    // Varios destinatarios
    $para  = CORREO_RECIBE; // atención a la coma
    // título
    $titulo = 'Actualización de reserva de cita';

    // mensaje
    $mensaje = '
    <html>
    <head>
      <title>Actualización de reserva de cita en el sistema</title>
    </head>
    <body>
      <h3 style="text-align : center;">' . APP_TITLE . '</h3>
      <table>
        <tr>
          <th style="text-align : center;">Descripción</th><th style="text-align : center;">Datos de Cita</th>
        </tr>
        <tr>
          <td>Actualización de fecha de cita.</td><td></td>
        </tr>
        <tr>
          <td>Cliente</td><td>' . $_SESSION['apellidos_cliente'] . ', ' . $_SESSION['nombres_cliente'] . '</td>
        </tr>
        <tr>
          <td>Fecha de cita </td><td>' . date('d/m/Y H:i', strtotime($fecha_1)) . '</td>
        </tr>
      </table>
    </body>
    </html>
    ';

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    $msg = "";
    // send the email
    if(!mail($para, $titulo, $mensaje, $cabeceras)){
      $msg = " : La cita se actualizó correctamente en el sistema, pero ocurrió un error al enviar el correo electrónico de aviso al administrador.";
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente" . $msg;
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
