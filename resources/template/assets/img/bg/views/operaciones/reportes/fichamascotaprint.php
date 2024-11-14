<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  require_once 'resources/pdf/vendor/autoload.php';

  try {

    $id_mascota = isset($_GET["id_mascota"])	? $_GET["id_mascota"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("fichamascota"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassEmpresa.php";
    $ResultadoEmpresa = $OBJ_EMPRESA->getEmpresa();
    if ($ResultadoEmpresa["error"]=="SI") {
      throw new Exception($ResultadoEmpresa["message"]);
    }
    $empresa = $ResultadoEmpresa["data"];

    require_once "core/models/ClassMascota.php";
    $ResultadoMascota = $OBJ_MASCOTA->getDataEditMascota($id_mascota);
    if ($ResultadoMascota["error"]=="SI") {
      throw new Exception($ResultadoMascota["message"]);
    }
    $arraymascota = $ResultadoMascota["data"];

    require_once "core/models/ClassMascotaVacuna.php";
    $DetalleVacuna = $OBJ_MASCOTA_VACUNA->showDetalleVacunas($id_mascota);
    if ($DetalleVacuna["error"]=="SI") {
      throw new Exception($DetalleVacuna["message"]);
    }
    $arraydetallevacuna = $DetalleVacuna["data"];

    $html1 = '<!DOCTYPE html>';
    $html1 .= '<html lang="en">';
    $html1 .= '<head>';
    $html1 .= '<meta charset="utf-8">';
    $html1 .= '<title>Ficha de Operación</title>';
    $html1 .= '<link rel="stylesheet" href="views/operaciones/reportes/style.css" media="all" />';
    $html1 .= '</head>';
    $html1 .= '<body>';
    $html1 .= '<header class="clearfix">';
    $html1 .= '<div id="logo" style="width: 80px; height: 80px;">';
    $html1 .= '<img src="' . $empresa[0]['src_logo'] . '">';
    $html1 .= '</div>';
    $html1 .= '<div id="company">';
    $html1 .= '<h2 class="name">' . $empresa[0]['razon_social'] . '</h2>';
    $html1 .= '<div>' . $empresa[0]['direccion'] . '</div>';
    $html1 .= '<div>' . $empresa[0]['fono01'] . '</div>';
    $html1 .= '<div><a href="mailto:' . $empresa[0]['correo01'] . '">' . $empresa[0]['correo01'] . '</a></div>';
    $html1 .= '</div>';
    $html1 .= '</div>';
    $html1 .= '</header>';
    $html1 .= '<main>';
    $html1 .= '<div id="details" class="clearfix">';
    $html1 .= '<div id="client">';
    $html1 .= '<div class="to">CLIENTE:</div>';
    $html1 .= '<h2 class="name">' . strtoupper($arraymascota[0]['apellidos']) . ', ' . $arraymascota[0]['nombres'] . '</h2>';
    $html1 .= '<div class="address">' . $arraymascota[0]['direccion'] . '</div>';
    $html1 .= '<div class="email"><a href="mailto:' . $arraymascota[0]['correo'] . '">' . $arraymascota[0]['correo'] . '</a></div>';
    $html1 .= '</div>';
    $html1 .= '<div style="width: 120px; height: 100px;float: right;padding-left: 20px;">';
    $html1 .= '<img src="' . $arraymascota[0]['src_imagen'] . '">';
    $html1 .= '</div>';
    $html1 .= '<div id="invoice" style="float: right; text-align: right;">';
    $html1 .= '<h1>' . strtoupper($arraymascota[0]['nombre']) . '</h1>';
    $html1 .= '<div class="date">Raza : ' . $arraymascota[0]['raza'] . '</div>';
    $html1 .= '<div class="date">F. Nacimiento: ' . date('d/m/Y', strtotime($arraymascota[0]['fecha_nacimiento'])) . '</div>';
    $html1 .= '</div>';
    $html1 .= '</div>';
    $html1 .= '<table border="0" cellspacing="0" cellpadding="0">';
    $html1 .= '<thead>';
    $html1 .= '<tr>';
    $html1 .= '<th class="no">#</th>';
    $html1 .= '<th class="desc">DESCRIPCIÓN</th>';
    $html1 .= '<th class="unit">MÉDICO</th>';
    $html1 .= '<th class="qty">SUCURSAL</th>';
    $html1 .= '<th class="qty">ESTADO</th>';
    $html1 .= '</tr>';
    $html1 .= '</thead>';
    $html1 .= '<tbody>';
    $count = 1;
    foreach ($arraydetallevacuna as $key) {
      $fecha_aplicacion = date('d/m/Y H:i', strtotime($key['fecha_aplicacion']));
      $flag_vacuna = $key['flag_vacuna'];
      $observaciones = $key['observaciones'];
      if ($flag_vacuna=="0") {
        $flag_vacuna = '<span class="badge-warning">NO VACUNADO</span>';
        $fecha_aplicacion = '';
        if (strtotime($key['fecha_maxima'])<strtotime(date('Y-m-d H:i'))) {
          $flag_vacuna = '<span class="badge-danger">VACUNA VENCIDA</span>';
        }
      } else {
        $flag_vacuna = '<span class="badge-success">VACUNADO</span>';
      }
      $html1 .= '<tr>';
      $html1 .= '<td class="no">' . $count . '</td>';
      $html1 .= '<td class="desc">';
      $html1 .= '<h4>';
      $html1 .= $key['name_vacuna'];
      $html1 .= '</h4>';
      $html1 .= 'Fecha de Inicio : ' . date('d/m/Y', strtotime($key['fecha_minima'])) . ' <br>';
      $html1 .= 'Fecha de Término : ' . date('d/m/Y', strtotime($key['fecha_maxima'])) . ' <br>';
      if ($fecha_aplicacion!='') {
        $html1 .= 'Fecha de Aplicación : ' . $fecha_aplicacion;
      }
      $html1 .= '<br>';
      $html1 .= '</td>';
      $html1 .= '<td><p>' . $key['name_user'] . '</p></td>';
      $html1 .= '<td><p>' . $key['name_sucursal'] . '</p></td>';
      $html1 .= '<td class="qty">' . $flag_vacuna . '</td>';
      $html1 .= '</tr>';
      $count++;
    }
    $html1 .= '</tbody>';
    $html1 .= '<tfoot>';
    $html1 .= '<tr>';
    $html1 .= '<td colspan="2"></td>';
    $html1 .= '<td colspan="2">&nbsp;</td>';
    $html1 .= '<td>&nbsp;</td>';
    $html1 .= '</tr>';
    $html1 .= '<tr>';
    $html1 .= '<td colspan="2"></td>';
    $html1 .= '<td colspan="2">&nbsp;</td>';
    $html1 .= '<td>&nbsp;</td>';
    $html1 .= '</tr>';
    $html1 .= '</tfoot>';
    $html1 .= '</table>';
    $html1 .= '<div id="notices">';
    $html1 .= '<div>Fecha de Descarga:</div>';
    $html1 .= '<div class="notice">' . fechaCastellano(date('d-m-Y H:i:s')) . '</div>';
    $html1 .= '</div>';
    $html1 .= '</main>';
    $html1 .= '<footer>';
    $html1 .= 'La ficha de mascota se creó en una computadora y es válida sin la firma y el sello.';
    $html1 .= '</footer>';
    $html1 .= '</body>';
    $html1 .= '</html>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html1);
    $mpdf->Output();

  } catch (\Exception $e) {
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML("<h1>" . $e->getMessage() . "</h1>");
    $mpdf->Output();
  }

?>
