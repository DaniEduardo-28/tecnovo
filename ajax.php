<?php

  require('core/core.php');

  try {

    if (isset($_POST)) {
      switch (isset($_GET['accion']) ? $_GET['accion'] : null) {
        case 'goSuscribirse':
          require("admin/core/ajax/frontend/goSuscribirse.php");
          break;
        case 'goMail':
          require("admin/core/ajax/frontend/goMail.php");
          break;
        case 'goLogin':
          require("admin/core/ajax/frontend/goLogin.php");
          break;
        case 'goResgistro':
          require("admin/core/ajax/frontend/goResgistro.php");
          break;
        case 'goUpdateImageProfile':
          require("admin/core/ajax/frontend/goUpdateImageProfile.php");
          break;
        case 'goMyProfile':
          require("admin/core/ajax/frontend/goMyProfile.php");
          break;
        case 'changePassword':
          require("admin/core/ajax/frontend/changePassword.php");
          break;
        case 'showMascota':
          require("admin/core/ajax/frontend/showMascota.php");
          break;
        case 'getDataEditMascota':
          require("admin/core/ajax/frontend/getDataEditMascota.php");
          break;
        case 'goMascota':
          require("admin/core/ajax/frontend/goMascota.php");
          break;
        case 'showCitasCliente':
          require("admin/core/ajax/frontend/showCitasCliente.php");
          break;
        case 'showServicioMedico':
          require("admin/core/ajax/frontend/showServicioMedico.php");
          break;
        case 'goCita':
          require("admin/core/ajax/frontend/goCita.php");
          break;
        case 'cancelarCita':
          require("admin/core/ajax/frontend/cancelarCita.php");
          break;
        case 'actualizarCita':
          require("admin/core/ajax/frontend/actualizarCita.php");
          break;
        case 'showMedicosSucursal':
          require("admin/core/ajax/frontend/showMedicosSucursal.php");
          break;

        default:
          $data["error"]="SI";
          $data["message"]="No se encontró el ajax especificado.";
          $data["data"] = null;
          echo json_encode($data);
          break;
      }
    }else{
      $data["error"]="SI";
      $data["message"]="No se recibieron los valores válidos.";
      $data["data"] = null;
      echo json_encode($data);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
  }

 ?>
