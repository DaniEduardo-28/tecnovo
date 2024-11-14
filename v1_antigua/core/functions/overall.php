<?php

  function formattodate($date,$formatin,$formatout){
    try {
      $newDate = date_create_from_format("$formatin", $date);
      $newDate = $newDate->format("$formatout");
      return $newDate;
    } catch (\Exception $e) {
      $newDate = date_create_from_format("Y-m-d", "2018-01-01");
      $newDate = $newDate->format("Y-m-d");
      return $newDate;
    }
  }

  function validar_email($email){
    try {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
      }else {
        return false;
      }
    } catch (\Exception $e) {
      return false;
    }
  }

  function validar_number($number){
    try {
      $number = intval($number);
      if (filter_var($number, FILTER_VALIDATE_INT)) {
        return true;
      }else {
        return false;
      }
    } catch (\Exception $e) {
      return false;
    }
  }

  function fechaCastellano($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
  }

  function numbertomes($number){
    try {
      switch ($number) {
        case '1':
          return "Enero";
          break;
        case '2':
          return "Febrero";
          break;
        case '3':
          return "Marzo";
          break;
        case '4':
          return "Abril";
          break;
        case '5':
          return "Mayo";
          break;
        case '6':
          return "Junio";
          break;
        case '7':
          return "Julio";
          break;
        case '8':
          return "Agosto";
          break;
        case '9':
          return "Septiembre";
          break;
        case '10':
          return "Octubre";
          break;
        case '11':
          return "Noviembre";
          break;
        case '12':
          return "Diciembre";
          break;
        default:
          return "Mes no encontrado.";
          break;
      }
    } catch (\Exception $e) {
      return $e;
    }
  }

  function right($str, $length) {
    return substr($str, -$length);
  }
  
 ?>
